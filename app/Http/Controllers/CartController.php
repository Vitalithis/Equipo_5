<?php

namespace App\Http\Controllers;

use App\Models\Producto; // Asegúrate de tener esto al inicio
use App\Models\CartItem;
use Illuminate\Http\Request;

use App\Models\Descuento;

class CartController extends Controller
{
    public function index()
    {
        // Cargar y devolver la vista con los elementos del carrito
        return view('cart.index'); // Aquí hacemos referencia a la vista cart.index
    }

    // Guardar el carrito en la base de datos
    public function guardarCarrito(Request $request)
    {
        $user = auth()->user(); // Obtener el usuario autenticado

        // Borrar el carrito previo (si existe)
        ventas::where('user_id', $user->id)->delete();

        // Guardar cada item del carrito
        foreach ($request->items as $item) {
            ventas::create([
                'user_id' => $user->id,
                'producto_id' => $item['id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
            ]);
        }

        return response()->json(['message' => 'Carrito guardado con éxito.']);
    }

    // Obtener el carrito del usuario
    public function obtenerCarrito()
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        $cartItems = CartItem::where('user_id', $user->id)->with('producto')->get();

        return response()->json([
            'items' => $cartItems,
        ]);
    }


    // Añadir al carrito
    public function añadirCarrito(Request $request, $id)
    {
        $producto = Producto::findOrFail($id); // Buscar producto
        $cantidad = $request->input('cantidad', 1);

        // Obtener carrito actual de la sesión
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['cantidad'] += $cantidad;
        } else {
            $cart[$id] = [
                'nombre'   => $producto->nombre,
                'precio'   => $producto->precio,
                'cantidad' => $cantidad,
                'imagen'   => $producto->imagen ?? '/images/default.png',
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Producto añadido al carrito.');
    }


    

    public function actualizarProducto(Request $request, $id)
    {
        // Obtener el carrito de la sesión
        $cart = session()->get('cart', []);

        // Verificar si el producto existe en el carrito
        if (isset($cart[$id])) {
            // Actualizar la cantidad del producto
            $cart[$id]['cantidad'] = $request->input('cantidad', $cart[$id]['cantidad']);

            // Guardar el carrito actualizado en la sesión
            session()->put('cart', $cart);

            return redirect()->route('cart.index')->with('success', 'Carrito actualizado');
        }

        return redirect()->route('cart.index')->with('error', 'Producto no encontrado en el carrito');
    }
    public function remove($id)
    {
        // Eliminar el producto del carrito de la sesión
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        // Retornar una respuesta
        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito.');
    }
    
    public function vaciarCarrito()
    {
        // Vaciar el carrito en la sesión
        session()->forget('cart');

        // Redirigir al carrito con un mensaje de éxito
        return redirect()->route('cart.index')->with('success', 'Carrito vaciado.');
    }

    public function aplicarDescuento(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string'
        ]);

        $codigo = $request->input('codigo');
        $descuento = Descuento::where('codigo', $codigo)->first();

        if (!$descuento) {
            return redirect()->route('cart.index')->with('error', 'Código de descuento no encontrado.');
        }

        // Verificar si el descuento es aplicable
        // Verificar si el descuento es aplicable directamente en el controlador
        if ($descuento->fecha_expiracion && $descuento->fecha_expiracion < now()) {
            return redirect()->route('cart.index')->with('error', 'Este descuento ha expirado.');
        }

        if ($descuento->uso_maximo && $descuento->usos >= $descuento->uso_maximo) {
            return redirect()->route('cart.index')->with('error', 'Este descuento ha alcanzado su límite de usos.');
        }

        // Aplicar el descuento al carrito
        $cart = session('cart', []);

        foreach ($cart as $id => $item) {
            $precioOriginal = $item['precio'];

            if ($descuento->tipo === 'porcentaje') {
            $precioConDescuento = $precioOriginal - ($precioOriginal * ($descuento->porcentaje / 100));
            } elseif ($descuento->tipo === 'monto_fijo') {
            $precioConDescuento = max(0, $precioOriginal - $descuento->monto_fijo);
            } else {
            $precioConDescuento = $precioOriginal; // Si no hay tipo válido, mantener el precio original
            }

            $cart[$id]['precio_con_descuento'] = $precioConDescuento;
            $cart[$id]['descuento_aplicado'] = $precioOriginal - $precioConDescuento;
        }

        // Guardar en sesión
        session([
            'cart' => $cart,
            'descuento_aplicado' => [
                'codigo' => $descuento->codigo,
                'valor' => $descuento->porcentaje ?? $descuento->monto_fijo,
                'tipo' => $descuento->tipo
            ]
        ]);

        // Registrar el uso del descuento directamente en el controlador
        $descuento->increment('usos_actuales');
        return redirect()->route('cart.index')->with('success', 'Descuento aplicado correctamente.');
    }
}
