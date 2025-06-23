<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use App\Models\InsumoDetalle;
use App\Models\Finanza;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    public function index()
    {
        $insumos = Insumo::orderBy('created_at', 'desc')->get();
        return view('dashboard.supply.insumos', compact('insumos'));
    }

    public function create()
    {
        return view('dashboard.supply.insumos_edit', ['insumo' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'cantidad' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'detalles' => 'nullable|array',
            'detalles.*.nombre' => 'required_with:detalles.*.cantidad,detalles.*.costo|string|max:255',
            'detalles.*.cantidad' => 'required_with:detalles.*.nombre|integer|min:1',
            'detalles.*.costo' => 'required_with:detalles.*.nombre|integer|min:0',
        ]);

        $insumo = Insumo::create([
            'nombre' => $request->nombre,
            'cantidad' => $request->cantidad,
            'costo' => 0, // Se recalcula abajo
            'descripcion' => $request->descripcion,
        ]);

        $costoTotal = 0;

        if ($request->filled('detalles')) {
            foreach ($request->detalles as $detalle) {
                if (!empty($detalle['nombre']) && isset($detalle['cantidad']) && isset($detalle['costo'])) {
                    $insumo->detalles()->create([
                        'nombre' => $detalle['nombre'],
                        'cantidad' => $detalle['cantidad'],
                        'costo_unitario' => $detalle['costo'],
                    ]);

                    $costoTotal += $detalle['cantidad'] * $detalle['costo'];
                }
            }

            // Actualiza el costo en la tabla insumos
            $insumo->update([
                'costo' => $costoTotal / max(1, $request->cantidad), // promedio por unidad
            ]);
        }

        if ($costoTotal > 0) {
        Finanza::create([
        'fecha' => now(),
        'tipo' => 'egreso',
        'monto' => $costoTotal,
        'categoria' => 'Compra de Insumos',
        'descripcion' => $request->nombre,
        'created_by' => auth()->id(),
    ]);
}


        return redirect()->route('dashboard.insumos')->with('success', 'Insumo y subdetalles guardados correctamente.');
    }

    public function edit($id)
{
    $insumo = Insumo::with('detalles')->findOrFail($id);
    return view('dashboard.supply.insumos_edit', compact('insumo'));
}


    public function update(Request $request, $id)
{
    $insumo = Insumo::findOrFail($id);

    $request->validate([
        'nombre' => 'required|string|max:255|unique:insumos,nombre,' . $insumo->id,
        'cantidad' => 'required|integer|min:0',
        'descripcion' => 'nullable|string',
        'detalles' => 'nullable|array',
        'detalles.*.nombre' => 'required_with:detalles.*.cantidad,detalles.*.costo|string|max:255',
        'detalles.*.cantidad' => 'required_with:detalles.*.nombre|integer|min:1',
        'detalles.*.costo' => 'required_with:detalles.*.nombre|integer|min:0',
    ]);

    // Actualiza los campos principales del insumo
    $insumo->update([
        'nombre' => $request->nombre,
        'cantidad' => $request->cantidad,
        'descripcion' => $request->descripcion,
    ]);

    // Borra subdetalles anteriores
    $insumo->detalles()->delete();

    $costoTotal = 0;

    // Crea nuevos subdetalles si existen
    if ($request->filled('detalles')) {
        foreach ($request->detalles as $detalle) {
            if (!empty($detalle['nombre']) && isset($detalle['cantidad']) && isset($detalle['costo'])) {
                $insumo->detalles()->create([
                    'nombre' => $detalle['nombre'],
                    'cantidad' => $detalle['cantidad'],
                    'costo_unitario' => $detalle['costo'],
                ]);

                $costoTotal += $detalle['cantidad'] * $detalle['costo'];
            }
        }

        // Calcula y actualiza el costo promedio por unidad
        $insumo->update([
            'costo' => $costoTotal / max(1, $request->cantidad),
        ]);
    }

    return redirect()->route('dashboard.insumos')->with('success', 'Insumo actualizado correctamente.');
}

    public function destroy($id)
    {
        $insumo = Insumo::findOrFail($id);
        $insumo->delete();

        return redirect()->route('dashboard.insumos')->with('success', 'Insumo eliminado correctamente.');
    }
}
