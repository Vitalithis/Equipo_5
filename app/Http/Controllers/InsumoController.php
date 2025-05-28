<?php

namespace App\Http\Controllers;

use App\Models\Insumo;
use Illuminate\Http\Request;

class InsumoController extends Controller
{
    public function index()
    {
        $insumos = Insumo::orderBy('created_at', 'desc')->get();
        return view('dashboard.insumos', compact('insumos'));
    }

    public function create()
    {
        return view('dashboard.insumos_edit', ['insumo' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_uso' => 'required|in:venta,uso',
            'stock' => 'required|integer|min:0',
            'precio' => 'nullable|integer|min:0',
            'descripcion' => 'nullable|string',
        ]);

        // Si es de uso interno, el precio debe ir en cero
        $datos = $request->all();
        if ($datos['tipo_uso'] === 'uso') {
            $datos['precio'] = 0;
        }

        Insumo::create($datos);

        return redirect()->route('dashboard.insumos')->with('success', 'Insumo creado correctamente.');
    }

    public function edit($id)
    {
        $insumo = Insumo::findOrFail($id);
        return view('dashboard.insumos_edit', compact('insumo'));
    }

    public function update(Request $request, $id)
    {
        $insumo = Insumo::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_uso' => 'required|in:venta,uso',
            'stock' => 'required|integer|min:0',
            'precio' => 'nullable|integer|min:0',
            'descripcion' => 'nullable|string',
        ]);

        $datos = $request->all();
        if ($datos['tipo_uso'] === 'uso') {
            $datos['precio'] = 0;
        }

        $insumo->update($datos);

        return redirect()->route('dashboard.insumos')->with('success', 'Insumo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $insumo = Insumo::findOrFail($id);
        $insumo->delete();

        return redirect()->route('dashboard.insumos')->with('success', 'Insumo eliminado correctamente.');
    }
}

