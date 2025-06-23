<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Pedido;
use App\Models\Descuento;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $cart = session()->get('cart', []);

        $descuentoPersonalizado = $user->descuento_personalizado ?? 0;

        if ($descuentoPersonalizado > 0) {
            foreach ($cart as $id => &$item) {
                $precioOriginal = $item['precio'];
                // Aplica descuento porcentual
                $precioConDescuento = $precioOriginal * (1 - $descuentoPersonalizado / 100);
                $item['precio_con_descuento'] = $precioConDescuento;
                $item['descuento_aplicado'] = $precioOriginal - $precioConDescuento;
            }
            unset($item);

            session(['cart' => $cart]);
            session(['descuento_aplicado' => [
                'codigo' => 'Descuento personalizado',
                'tipo' => 'porcentaje',
                'valor' => $descuentoPersonalizado,
            ]]);
        } else {
            // Sin descuento personalizado, limpia el campo descuento_aplicado
            session()->forget('descuento_aplicado');

            // Igualar precio_con_descuento a precio para evitar errores en vista
            foreach ($cart as $id => &$item) {
                $item['precio_con_descuento'] = $item['precio'];
                $item['descuento_aplicado'] = 0;
            }
            unset($item);

            session(['cart' => $cart]);
        }

        return view('cart.index');
    }

    public function guardarCarrito(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'metodo_entrega' => 'required|in:retiro,domicilio',
            'direccion_entrega' => 'required_if:metodo_entrega,domicilio|string|nullable',
            'items' => 'required|array|min:1',
        ]);

        // Crear nuevo pedido
        $pedido = Pedido::create([
            'usuario_id' => $user->id,
            'total' => 0, // Se actualizará al final
            'estado_pedido' => 'pendiente',
            'metodo_entrega' => $request->input('metodo_entrega'),
            'direccion_entrega' => $request->input('metodo_entrega') === 'domicilio'
                ? $request->input('direccion_entrega')
                : null,
        ]);

        $total = 0;

        foreach ($request->items as $item) {
            $subtotal = $item['precio'] * $item['cantidad'];
            $total += $subtotal;

            $pedido->productos()->attach($item['id'], [
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio'],
                'subtotal' => $subtotal,
                'nombre_producto_snapshot' => $item['nombre'],
                'codigo_barras_snapshot' => $item['codigo_barras'] ?? null,
                'imagen_snapshot' => $item['imagen'] ?? null,
            ]);
        }

        $pedido->update(['total' => $total]);

        return response()->json(['message' => 'Pedido guardado con éxito.']);
    }


    public function obtenerCarrito()
    {
        $user = auth()->user();
        $cart = session()->get('cart', []);

        return response()->json(['items' => $cart]);
    }

    public function añadirCarrito(Request $request, $id)
    {
        $user = auth()->user();
        $descuentoPersonalizado = $user->descuento_personalizado ?? 0;

        $producto = Producto::findOrFail($id);
        $cantidad = $request->input('cantidad', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['cantidad'] += $cantidad;
        } else {
            $cart[$id] = [
                'nombre'   => $producto->nombre,
                'precio'   => $producto->precio,
                'cantidad' => $cantidad,
                'imagen'   => $producto->imagen ?? '/images/default.png',
                'codigo_barras' => $producto->codigo_barras ?? null,
            ];
        }

        if ($descuentoPersonalizado > 0) {
            $precioOriginal = $cart[$id]['precio'];
            $precioConDescuento = $precioOriginal * (1 - $descuentoPersonalizado / 100);
            $cart[$id]['precio_con_descuento'] = $precioConDescuento;
            $cart[$id]['descuento_aplicado'] = $precioOriginal - $precioConDescuento;
        } else {
            $cart[$id]['precio_con_descuento'] = $cart[$id]['precio'];
            $cart[$id]['descuento_aplicado'] = 0;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Producto añadido al carrito.');
    }

    public function ajaxAñadirCarrito(Request $request, $id)
    {
        $user = auth()->user();
        $descuentoPersonalizado = $user->descuento_personalizado ?? 0;

        $request->validate([
            'cantidad' => 'required|integer|min:1|max:99',
        ]);

        $producto = Producto::findOrFail($id);
        $cantidad = (int) $request->input('cantidad', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['cantidad'] += $cantidad;
        } else {
            $cart[$id] = [
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => $cantidad,
                'imagen' => $producto->imagen ?? '/images/default.png',
                'codigo_barras' => $producto->codigo_barras ?? null,
            ];
        }

        if ($descuentoPersonalizado > 0) {
            $precioOriginal = $cart[$id]['precio'];
            $precioConDescuento = $precioOriginal * (1 - $descuentoPersonalizado / 100);
            $cart[$id]['precio_con_descuento'] = $precioConDescuento;
            $cart[$id]['descuento_aplicado'] = $precioOriginal - $precioConDescuento;
        } else {
            $cart[$id]['precio_con_descuento'] = $cart[$id]['precio'];
            $cart[$id]['descuento_aplicado'] = 0;
        }

        session()->put('cart', $cart);

        \Log::debug('Carrito actualizado vía AJAX', [
            'user_id' => auth()->id(),
            'producto_id' => $id,
            'cantidad' => $cart[$id]['cantidad'],
            'cart' => $cart
        ]);

        return response()->json([
            'message' => 'Producto añadido al carrito.',
            'cart_count' => array_sum(array_column($cart, 'cantidad')),
            'producto' => [
                'id' => $id,
                'nombre' => $producto->nombre,
                'cantidad' => $cart[$id]['cantidad'],
            ],
            'debug_cart' => app()->environment('local') ? $cart : null,
        ]);
    }

    public function actualizarProducto(Request $request, $id)
    {
        $user = auth()->user();
        $descuentoPersonalizado = $user->descuento_personalizado ?? 0;

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['cantidad'] = $request->input('cantidad', $cart[$id]['cantidad']);

            if ($descuentoPersonalizado > 0) {
                $precioOriginal = $cart[$id]['precio'];
                $precioConDescuento = $precioOriginal * (1 - $descuentoPersonalizado / 100);
                $cart[$id]['precio_con_descuento'] = $precioConDescuento;
                $cart[$id]['descuento_aplicado'] = $precioOriginal - $precioConDescuento;
            } else {
                $cart[$id]['precio_con_descuento'] = $cart[$id]['precio'];
                $cart[$id]['descuento_aplicado'] = 0;
            }

            session()->put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Carrito actualizado');
        }

        return redirect()->route('cart.index')->with('error', 'Producto no encontrado en el carrito');
    }


    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Producto eliminado del carrito.');
    }

    public function vaciarCarrito()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Carrito vaciado.');
    }

    public function aplicarDescuento(Request $request)
    {
        $request->validate(['codigo' => 'required|string']);

        $codigo = $request->input('codigo');
        $descuento = Descuento::where('codigo', $codigo)->first();

        if (!$descuento) {
            return redirect()->route('cart.index')->with('error', 'Código de descuento no encontrado.');
        }

        if ($descuento->fecha_expiracion && $descuento->fecha_expiracion < now()) {
            return redirect()->route('cart.index')->with('error', 'Este descuento ha expirado.');
        }

        if ($descuento->uso_maximo && $descuento->usos_actuales >= $descuento->uso_maximo) {
            return redirect()->route('cart.index')->with('error', 'Este descuento ha alcanzado su límite de usos.');
        }

        $cart = session('cart', []);
        foreach ($cart as $id => $item) {
            $precioOriginal = $item['precio'];
            if ($descuento->tipo === 'porcentaje') {
                $precioConDescuento = $precioOriginal - ($precioOriginal * ($descuento->porcentaje / 100));
            } elseif ($descuento->tipo === 'monto_fijo') {
                $precioConDescuento = max(0, $precioOriginal - $descuento->monto_fijo);
            } else {
                $precioConDescuento = $precioOriginal;
            }

            $cart[$id]['precio_con_descuento'] = $precioConDescuento;
            $cart[$id]['descuento_aplicado'] = $precioOriginal - $precioConDescuento;
        }

        session([
            'cart' => $cart,
            'descuento_aplicado' => [
                'codigo' => $descuento->codigo,
                'valor' => $descuento->porcentaje ?? $descuento->monto_fijo,
                'tipo' => $descuento->tipo
            ]
        ]);

        $descuento->increment('usos_actuales');
        return redirect()->route('cart.index')->with('success', 'Descuento aplicado correctamente.');
    }
}
