<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class BoletaController extends Controller
{
    /**
     * Mostrar boleta provisoria (pantalla simple).
     */
    public function generar($pedidoId)
    {
        $pedido = Pedido::with('detalles', 'usuario')->findOrFail($pedidoId);

        $subtotal = $pedido->detalles->sum('subtotal');
        $descuento = $subtotal * 0.10;
        $totalFinal = $subtotal - $descuento;

        return view('boletas.provisoria', compact('pedido', 'subtotal', 'descuento', 'totalFinal'));
    }

    /**
     * Generar y descargar PDF.
     */
    public function generarPDF($pedidoId)
    {
        $pedido = Pedido::with('detalles', 'usuario')->findOrFail($pedidoId);

        $subtotal = $pedido->detalles->sum('subtotal');
        $descuento = $subtotal * 0.10;
        $totalFinal = $subtotal - $descuento;

        $pdf = PDF::loadView('boletas.pdf', compact('pedido', 'subtotal', 'descuento', 'totalFinal'));

        return $pdf->download("boleta_pedido_{$pedido->id}.pdf");
    }

    /**
     * Guardar boleta PDF subida por el usuario.
     */
    public function guardar(Request $request, $pedidoId)
    {
        $request->validate([
            'boleta' => 'required|mimes:pdf|max:2048',
        ]);

        $pedido = Pedido::findOrFail($pedidoId);

        $file = $request->file('boleta');
        $path = $file->store('boletas', 'public');

        $pedido->boleta_final_path = $path;
        $pedido->save();

        return redirect()->back()->with('success', 'Boleta subida correctamente.');
    }

    /**
     * Generar boleta provisoria desde otra vista.
     */
    public function generarProvisoria($pedidoId)
    {
        $pedido = Pedido::with('detalles', 'usuario')->findOrFail($pedidoId);

        $subtotal = $pedido->detalles->sum('subtotal');
        $descuento = $subtotal * 0.10;
        $totalFinal = $subtotal - $descuento;

        return view('boletas.boleta', compact('pedido', 'subtotal', 'descuento', 'totalFinal'));
    }
}
