<?php

namespace App\Http\Controllers;

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
}

