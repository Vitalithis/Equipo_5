<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        $producciones = Produccion::with(['producto', 'insumos'])->get();
        return view('dashboard.produccion.produccion', compact('producciones'));
    }

    public function producir(Request $request)
{
    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'cantidad' => 'required|integer|min:1',
    ]);

    $producto = Producto::with('insumos')->findOrFail($request->producto_id);
    $cantidad = $request->cantidad;

    // ✅ Validar si el producto no tiene insumos asociados
    if ($producto->insumos->isEmpty()) {
        return back()->with('error', 'El producto seleccionado no tiene insumos asociados. No se puede producir.');
    }

    // Validar stock de insumos
    if (!$producto->tieneStockParaProducir($cantidad)) {
        return back()->with('error', 'No hay suficiente stock de insumos.');
    }

    // Descontar stock de insumos
    $insumosUsados = [];
    foreach ($producto->insumos as $insumo) {
        $cantidadUsada = $insumo->pivot->cantidad * $cantidad;
        $insumo->cantidad -= $cantidadUsada;
        $insumo->save();
        $insumosUsados[$insumo->id] = ['cantidad_usada' => $cantidadUsada];
    }

    // Registrar producción
    $produccion = Produccion::create([
        'producto_id' => $producto->id,
        'cantidad_producida' => $cantidad,
    ]);

    $produccion->insumos()->attach($insumosUsados);

    return back()->with('success', "Producción de {$cantidad} unidades registrada correctamente.");
}


    public function edit($id)
    {
        $produccion = Produccion::with('insumos', 'producto')->findOrFail($id);
        $productos = Producto::with('insumos')->get();

        return view('dashboard.produccion.produccion_edit', compact('produccion', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $produccion = Produccion::findOrFail($id);
        $produccion->update([
            'producto_id' => $request->producto_id,
            'cantidad_producida' => $request->cantidad,
        ]);

        // Nota: no modificamos insumos usados aquí, pero podrías implementarlo si es necesario

        return redirect()->route('produccion.index')->with('success', 'Producción actualizada correctamente.');
    }

    public function destroy($id)
    {
        $produccion = Produccion::findOrFail($id);
        $produccion->insumos()->detach();
        $produccion->delete();

        return redirect()->route('produccion.index')->with('success', 'Producción eliminada correctamente.');
    }
    public function create()
{
    $productos = Producto::with('insumos')->get();
    return view('dashboard.produccion.produccion_edit', compact('productos'));
}
}
