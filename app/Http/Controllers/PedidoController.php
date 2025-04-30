<?php
namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PedidoController extends Controller
{
    // Mostrar todos los pedidos
    public function index()
    {
        $pedidos = Pedido::with('usuario')->orderByDesc('id')->get();
        return view('pedidos.index', compact('pedidos'));
    }

    // Ver detalle de un pedido
    public function show(Pedido $pedido)
    {
        $pedido->load('usuario', 'detalles.producto');
    
        return view('pedidos.show', compact('pedido'));
    }
    

    // Cambiar el estado del pedido
    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'estado_pedido' => 'required|in:pendiente,en_preparacion,en_camino,enviado,entregado,listo_para_retiro',
        ]);
    
        $pedido->estado_pedido = $request->estado_pedido;
        $pedido->save();
    
        return redirect()->route('pedidos.index')->with('success', 'Estado actualizado correctamente.');
    }
    

    // Generar boleta provisional en PDF
    public function generarBoleta(Pedido $pedido)
    {
        $pedido->load('usuario', 'detalles.producto');

        $pdf = Pdf::loadView('pdf.boleta', compact('pedido'));
        return $pdf->download("boleta-pedido-{$pedido->id}.pdf");
    }

    // Subir boleta oficial del SII
    public function subirBoleta(Request $request, Pedido $pedido)
    {
        $request->validate([
            'boleta_pdf' => 'required|mimes:pdf|max:2048'
        ]);

        $path = $request->file('boleta_pdf')->store('boletas_sii');

        $pedido->boleta_final_path = $path;
        $pedido->documento_generado = true;
        $pedido->save();

        return back()->with('success', 'Boleta SII subida correctamente.');
    }
}
