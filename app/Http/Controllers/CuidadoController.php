<?php

namespace App\Http\Controllers;

use App\Models\Cuidado;
use App\Models\Producto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CuidadoController extends Controller
{
    public function index()
    {
        $cuidados = Cuidado::with('producto')->orderBy('created_at', 'desc')->get();
        return view('dashboard.cuidados', compact('cuidados'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('dashboard.cuidados_edit', [
            'cuidado' => null,
            'productos' => $productos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'frecuencia_riego' => 'required|string',
            'cantidad_agua' => 'required|string',
            'tipo_luz' => 'required|string',
            'temperatura_ideal' => 'nullable|string',
            'tipo_sustrato' => 'nullable|string',
            'frecuencia_abono' => 'nullable|string',
            'plagas_comunes' => 'nullable|string',
            'cuidados_adicionales' => 'nullable|string',
            'imagen_url' => 'nullable|url',
        ]);

        Cuidado::create($request->all());

        return redirect()->route('dashboard.cuidados')->with('success', 'Cuidado registrado exitosamente.');
    }

    public function edit($id)
    {
        $cuidado = Cuidado::findOrFail($id);
        $productos = Producto::all();

        return view('dashboard.cuidados.edit', compact('cuidado', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $cuidado = Cuidado::findOrFail($id);

        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'frecuencia_riego' => 'required|string',
            'cantidad_agua' => 'required|string',
            'tipo_luz' => 'required|string',
            'temperatura_ideal' => 'nullable|string',
            'tipo_sustrato' => 'nullable|string',
            'frecuencia_abono' => 'nullable|string',
            'plagas_comunes' => 'nullable|string',
            'cuidados_adicionales' => 'nullable|string',
            'imagen_url' => 'nullable|url',
        ]);

        $cuidado->update($request->all());

        return redirect()->route('dashboard.cuidados')->with('success', 'Cuidado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $cuidado = Cuidado::findOrFail($id);
        $cuidado->delete();

        return redirect()->route('dashboard.cuidados')->with('success', 'Cuidado eliminado correctamente.');
    }
    public function generarPdf($id)
{
    $cuidado = Cuidado::with('producto')->findOrFail($id);

    $filename = 'cuidado_' . $cuidado->id . '.pdf';
    $path = 'public/cuidados/' . $filename;

    // Si ya existe, servir directamente
    if (Storage::exists($path)) {
        return response()->file(storage_path('app/' . $path));
    }

    // Generar PDF y guardar
    $pdf = Pdf::loadView('cuidado.cuidado', compact('cuidado'));
    Storage::put($path, $pdf->output());

    // Servir el archivo generado
    return response()->file(storage_path('app/' . $path));
}
}
