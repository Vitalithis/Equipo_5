<?php

namespace App\Http\Controllers;

use App\Models\OrdenProduccion;
use App\Models\Producto;
use Illuminate\Http\Request;

class OrdenProduccionController extends Controller
{
    public function index()
    {
        $ordenes = OrdenProduccion::with('producto')->orderBy('created_at', 'desc')->get();
        return view('dashboard.ordenes', compact('ordenes'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('dashboard.ordenes_edit', [
            'orden' => null,
            'productos' => $productos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|unique:orden_produccions,codigo',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'fecha_fin_estimada' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|string',
            'observaciones' => 'nullable|string',
        ]);

        OrdenProduccion::create($request->all());

        return redirect()->route('dashboard.ordenes')->with('success', 'Orden de producción creada exitosamente.');
    }

    public function edit($id)
    {
        $orden = OrdenProduccion::findOrFail($id);
        $productos = Producto::all();

        return view('dashboard.ordenes_edit', compact('orden', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $orden = OrdenProduccion::findOrFail($id);

        $request->validate([
            'codigo' => 'required|string|unique:orden_produccions,codigo,' . $orden->id,
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_inicio' => 'required|date',
            'fecha_fin_estimada' => 'nullable|date|after_or_equal:fecha_inicio',
            'estado' => 'required|string',
            'observaciones' => 'nullable|string',
        ]);

        $orden->update($request->all());

        return redirect()->route('dashboard.ordenes')->with('success', 'Orden actualizada correctamente.');
    }

    public function destroy($id)
    {
        $orden = OrdenProduccion::findOrFail($id);
        $orden->delete();

        return redirect()->route('dashboard.ordenes')->with('success', 'Orden eliminada correctamente.');
    }
}
