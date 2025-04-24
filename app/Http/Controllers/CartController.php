<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;    // si usas persistencia
use App\Models\Producto;

class CartController extends Controller
{
    // Vista del carrito
    public function index()
    {
        return view('cart.index');
    }

    // (Opcional) endpoints AJAX para persistir en sesión o BD

    public function add(Request $req)
    {
        $data = $req->validate([
            'id'       => 'required|integer',
            'cantidad' => 'required|integer|min:1',
        ]);

        // Ejemplo guardando en session
        $productos = session()->get('cart', []);
        $prod   = Producto::findOrFail($data['id']);
        $item   = [
            'id'       => $prod->id,
            'nombre'   => $prod->nombre,
            'precio'   => $prod->precio,
            'imagen'   => $prod->imagen,
            'cantidad' => $data['cantidad'],
        ];
        $productos[$prod->id] = $item;
        session()->put('cart', $productos);

        return response()->json(['success'=>true,'cart'=>$productos]);
    }

    public function update(Request $req)
    {
        $data = $req->validate([
            'id'       => 'required|integer',
            'cantidad' => 'required|integer|min:1',
        ]);
        $cart = session()->get('cart', []);
        if(isset($cart[$data['id']])) {
            $cart[$data['id']]['cantidad'] = $data['cantidad'];
            session()->put('cart',$cart);
        }
        return response()->json(['success'=>true,'cart'=>$cart]);
    }

    public function remove(Request $req)
    {
        $id = $req->validate(['id'=>'required|integer'])['id'];
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart',$cart);
        return response()->json(['success'=>true,'cart'=>$cart]);
    }

    public function clear()
    {
        session()->forget('cart');
        return response()->json(['success'=>true]);
    }
}
