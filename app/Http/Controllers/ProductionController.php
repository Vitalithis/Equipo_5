<?php

namespace App\Http\Controllers;
use App\Models\Produccion;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function producir(Request $request)
{
    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'cantidad' => 'required|integer|min:1',
    ]);

    $producto = Producto::findOrFail($request->producto_id);
    $cantidad = $request->cantidad;

    if (!$producto->tieneStockParaProducir($cantidad)) {
        return back()->with('error', 'No hay suficiente stock de insumos.');
    }

    // Descontar stock de insumos y guardar detalle
    $insumosUsados = [];
    foreach ($producto->insumos as $insumo) {
        $cantidadUsada = $insumo->pivot->cantidad * $cantidad;

        // Descontar del stock
        $insumo->cantidad -= $cantidadUsada;
        $insumo->save();

        $insumosUsados[$insumo->id] = ['cantidad_usada' => $cantidadUsada];
    }

    // Registrar la producción
    $produccion = Produccion::create([
        'producto_id' => $producto->id,
        'cantidad_producida' => $cantidad,
    ]);

    // Asociar insumos usados a esta producción
    $produccion->insumos()->attach($insumosUsados);

    return back()->with('success', "Producción de {$cantidad} unidades registrada correctamente.");
}
}
