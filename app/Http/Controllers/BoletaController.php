<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Pedido;
use Barryvdh\DomPDF\Facade\Pdf;


class BoletaController extends Controller
{
    public function generar(Pedido $pedido)
    {
        $pedido->load(['usuario', 'detalles']);

        $subtotal = $pedido->detalles->sum('subtotal');
        $descuento = $subtotal * 0.10;
        $totalFinal = $subtotal - $descuento;

        return view('boletas.boleta', compact('pedido', 'subtotal', 'descuento', 'totalFinal'));
    }
    public function generarPDF(Pedido $pedido)
    {
        $pedido->load(['usuario', 'detalles']);
        $subtotal = $pedido->detalles->sum('subtotal');
        $descuento = $subtotal * 0.10;
        $totalFinal = $subtotal - $descuento;

        $pdf = Pdf::loadView('boletas.pdf', compact('pedido', 'subtotal', 'descuento', 'totalFinal'))
                ->setPaper('A4');
        return $pdf->download('boleta-pedido-' . $pedido->id . '.pdf');
    }

    public function subir($id)
{
    $pedido = Pedido::findOrFail($id);
    return view('boletas.subir', compact('pedido'));
}

public function guardar(Request $request, $id)
{
    $request->validate([
        'boleta_pdf' => 'required|mimes:pdf|max:2048',
    ]);

    $pedido = Pedido::findOrFail($id);
    $path = $request->file('boleta_pdf')->store('boletas', 'public');

    $pedido->boleta_final_path = $path;
    $pedido->save();

    return redirect()->route('pedidos.index')->with('success', 'Boleta SII subida correctamente.');
}

}
