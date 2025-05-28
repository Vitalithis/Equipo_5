<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with(['usuario', 'productos'])->get();
        return view('pedidos.index', compact('pedidos'));

    }

    public function update(Request $request, $id)
    {
        $pedido = Pedido::findOrFail($id);

        // Obtiene los estados permitidos desde el modelo
        $allowedStates = array_keys($pedido->estadosPermitidos());

        // Valida que el estado esté dentro de los permitidos
        $request->validate([
            'estado_pedido' => ['required', Rule::in($allowedStates)],
        ]);

        // Actualiza el estado del pedido
        $pedido->estado_pedido = $request->estado_pedido;
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Estado del pedido actualizado correctamente.');
    }
}

