<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::all();
        return view('pedidos.index', compact('pedidos'));
    }

    public function cambiarEstado($id, Request $request)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,enviado,entregado',
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->estado = $request->estado;
        $pedido->save();

        return redirect()->back()->with('success', 'Estado actualizado');
    }
}
