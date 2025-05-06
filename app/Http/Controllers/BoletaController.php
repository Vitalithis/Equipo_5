<?php

namespace App\Http\Controllers;

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

}
