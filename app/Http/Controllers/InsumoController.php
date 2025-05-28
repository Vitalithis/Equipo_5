<?php

namespace App\Http\Controllers;


use App\Models\Insumo;
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
        'costo' => 'required|integer|min:0',
        'descripcion' => 'nullable|string',
    ]);

    $insumo = Insumo::where('nombre', $request->nombre)->first();

    if ($insumo) {
        // Aumentar cantidad y actualizar costo si se desea
        $insumo->cantidad += $request->cantidad;
        $insumo->costo = $request->costo;
        $insumo->save();
    } else {
        // Crear nuevo insumo
        $insumo = Insumo::create([
            'nombre' => $request->nombre,
            'cantidad' => $request->cantidad,
            'costo' => $request->costo,
            'descripcion' => $request->descripcion,
        ]);
    }

    // Registrar egreso automáticamente
    Finanza::create([
        'fecha' => now(),
        'tipo' => 'egreso',
        'monto' => $request->cantidad * $request->costo,
        'categoria' => 'Compra de Insumos',
        'descripcion' => $request->nombre,
        'created_by' => auth()->id(),
    ]);

    return redirect()->route('dashboard.insumos')->with('success', 'Insumo guardado y egreso registrado correctamente.');
}



    public function edit($id)
    {
        $insumo = Insumo::findOrFail($id);
        return view('dashboard.supply.insumos_edit', compact('insumo'));
    }

    public function update(Request $request, $id)
    {
        $insumo = Insumo::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:insumos,nombre,' . $insumo->id,
            'cantidad' => 'required|integer|min:0',
            'costo' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
        ]);

        $insumo->update([
            'nombre' => $request->nombre,
            'cantidad' => $request->cantidad,
            'costo' => $request->costo,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('dashboard.insumos')->with('success', 'Insumo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $insumo = Insumo::findOrFail($id);
        $insumo->delete();

        return redirect()->route('dashboard.insumos')->with('success', 'Insumo eliminado correctamente.');
    }
}
