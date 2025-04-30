<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Barryvdh\DomPDF\Facade\Pdf;

class BoletaController extends Controller
{
    public function generar(Request $request)
    {
        $pedidoId = $request->input('pedido_id');

        $pedido = Pedido::find($pedidoId);

        if (!$pedido) {
            return redirect()->back()->with('error', 'El pedido no existe.');
        }

        // Generar PDF usando la vista Blade
        $pdf = Pdf::loadView('boletas.pdf', compact('pedido'));

        return $pdf->download('boleta-pedido' . $pedido->id . '.pdf');
    }
}
