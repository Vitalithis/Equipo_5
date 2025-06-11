<?php

namespace App\Http\Controllers;

use App\Models\PlantTreatment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index()
    {
        $treatments = PlantTreatment::all();
        return view('dashboard.treatments.treatment', compact('treatments'));
    }

    public function create()
    {
        return view('dashboard.treatments.treatment_edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'composicion' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'peso' => 'nullable|numeric',
            'unidad_medida' => 'nullable|string|max:50',
            'presentacion' => 'nullable|string|max:255',
            'aplicacion' => 'nullable|string',
            'precio' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'fecha_vencimiento' => 'nullable|date',
            'frecuencia_aplicacion' => 'nullable|string|max:50',
            'ultima_aplicacion' => 'nullable|date',
            'fabricante' => 'nullable|string|max:255',
            'activo' => 'nullable|boolean',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $treatment = new PlantTreatment($request->except('imagen'));

        if ($request->hasFile('imagen')) {
            $treatment->imagen = $request->file('imagen')->store('treatments', 'public');
        }

        $treatment->activo = $request->has('activo');
        $treatment->save();

        return redirect()->route('dashboard.treatments')->with('success', 'Tratamiento registrado exitosamente.');
    }

    public function edit($id)
    {
        $treatment = PlantTreatment::findOrFail($id);
        return view('dashboard.treatments.treatment_edit', compact('treatment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'nullable|string|max:255',
            'composicion' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'peso' => 'nullable|numeric',
            'unidad_medida' => 'nullable|string|max:50',
            'presentacion' => 'nullable|string|max:255',
            'aplicacion' => 'nullable|string',
            'precio' => 'nullable|numeric',
            'stock' => 'nullable|integer',
            'fecha_vencimiento' => 'nullable|date',
            'frecuencia_aplicacion' => 'nullable|string|max:50',
            'ultima_aplicacion' => 'nullable|date',
            'fabricante' => 'nullable|string|max:255',
            'activo' => 'nullable|boolean',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $treatment = PlantTreatment::findOrFail($id);
        $treatment->fill($request->except('imagen'));

        if ($request->hasFile('imagen')) {
            $treatment->imagen = $request->file('imagen')->store('treatments', 'public');
        }

        $treatment->activo = $request->has('activo');
        $treatment->save();

        return redirect()->route('dashboard.treatments')->with('success', 'Tratamiento actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $treatment = PlantTreatment::findOrFail($id);
        $treatment->delete();

        return redirect()->route('dashboard.treatments')->with('success', 'Tratamiento eliminado exitosamente.');
    }
}
