<?php

namespace App\Http\Controllers;

use App\Models\OrdenProduccion;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;

class OrdenProduccionController extends Controller
{
    public function index()
    {
        $ordenes = OrdenProduccion::with('producto', 'trabajador')->orderBy('created_at', 'desc')->get();
        return view('dashboard.orden.ordenes', compact('ordenes'));
    }

    public function create()
    {
        $productos = Producto::all();
        $usuarios = User::role('admin')->get(); // o User::all() si no usas Spatie

        return view('dashboard.orden.ordenes_edit', [
            'orden' => null,
            'productos' => $productos,
            'usuarios' => $usuarios,
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
            'user_id' => 'nullable|exists:users,id',
        ]);

        OrdenProduccion::create($request->all());

        return redirect()->route('dashboard.ordenes')->with('success', 'Orden de producción creada exitosamente.');
    }

    public function edit($id)
    {
        $orden = OrdenProduccion::findOrFail($id);
        $productos = Producto::all();
        $usuarios = User::role('admin')->get(); // o User::all()

        return view('dashboard.orden.ordenes_edit', compact('orden', 'productos', 'usuarios'));
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
            'user_id' => 'nullable|exists:users,id',
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
