<?php

namespace App\Http\Controllers;
use App\Models\Producto; // Asegúrate de tener esto al inicio
use App\Models\CartItem;
use Illuminate\Http\Request;

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
        CartItem::where('user_id', $user->id)->delete();

        // Guardar cada item del carrito
        foreach ($request->items as $item) {
            CartItem::create([
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

    // Vaciar el carrito del usuario
    public function vaciarCarrito()
    {
        $user = auth()->user(); // Obtener el usuario autenticado
        CartItem::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Carrito vacío.']);
    }
    public function add(Request $request, $id)
{
    $user = auth()->user(); // Usuario autenticado
    $producto = Producto::findOrFail($id); // Buscar producto por ID

    $cantidad = $request->input('cantidad', 1);

    // Buscar si el producto ya está en el carrito del usuario
    $item = CartItem::where('user_id', $user->id)
        ->where('producto_id', $producto->id)
        ->first();

    if ($item) {
        // Si ya existe, incrementamos la cantidad
        $item->cantidad += $cantidad;
        $item->save();
    } else {
        // Si no existe, lo creamos
        CartItem::create([
            'user_id' => $user->id,
            'producto_id' => $producto->id,
            'cantidad' => $cantidad,
            'precio_unitario' => $producto->precio,
        ]);
    }

    return redirect()->back()->with('success', 'Producto añadido al carrito.');
}
public function agregarProducto(Request $request, $id)
{
    // Obtener el producto
    $producto = Producto::findOrFail($id);

    // Obtener la cantidad del producto, si no la proporciona, asignar 1
    $cantidad = $request->input('cantidad', 1);

    // Verificar si el producto ya está en el carrito de la sesión
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        // Si el producto ya está en el carrito, solo actualizamos la cantidad
        $cart[$id]['cantidad'] += $cantidad;
    } else {
        // Si el producto no está en el carrito, lo agregamos
        $cart[$id] = [
            'nombre' => $producto->nombre,
            'precio' => $producto->precio,
            'cantidad' => $cantidad,
            'imagen' => $producto->imagen,
        ];
    }

    // Guardar el carrito en la sesión
    session()->put('cart', $cart);

    // Redirigir a la página del carrito
    return redirect()->route('cart.index')->with('success', 'Producto agregado al carrito');
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
public function clear()
{
    // Vaciar el carrito en la sesión
    session()->forget('cart');

    // Redirigir al carrito con un mensaje de éxito
    return redirect()->route('cart.index')->with('success', 'Carrito vaciado.');
}

}

