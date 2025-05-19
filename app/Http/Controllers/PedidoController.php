<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Producto;


use Illuminate\Support\Facades\Auth; ///??

class PedidoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'metodo_entrega' => 'required|string',
            'estado_pedido' => 'required|string',
            'forma_pago' => 'required|string',
            'estado_pago' => 'required|string',
            'monto_pagado' => 'nullable|numeric',
            'tipo_documento' => 'required|string',
            'producto_id' => 'required|array',
            'cantidad' => 'required|array',
            'precio_unitario' => 'required|array',
        ]);

        $subtotal = 0;
        $descuento_porcentaje = floatval($request->codigo_descuento) ?: 0;
        $impuesto_rate = 0.19;

        // Crear pedido 
        $pedido = Pedido::create([
            'usuario_id' => Auth::id(),
            'metodo_entrega' => $request->metodo_entrega,
            'direccion_entrega' => $request->metodo_entrega === 'domicilio' ? $request->direccion_entrega : null,
            'estado_pedido' => $request->estado_pedido,
            'forma_pago' => $request->forma_pago,
            'estado_pago' => $request->estado_pago,
            'monto_pagado' => $request->monto_pagado ?? 0,
            'tipo_documento' => $request->tipo_documento,
            'observaciones' => $request->observaciones,
            'documento_generado' => false,
            'fecha_pedido' => now(),
        ]); 

        foreach ($request->producto_id as $i => $producto_id) {
            $cantidad = $request->cantidad[$i];
            $precio = $request->precio_unitario[$i];
            $subtotal_producto = $cantidad * $precio;
            $subtotal += $subtotal_producto;

            $producto = Producto::findOrFail($producto_id);

            DetallePedido::create([
            'pedido_id' => $pedido->id,
            'producto_id' => $producto_id,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
            'subtotal' => $subtotal_producto,
            'nombre_producto_snapshot' => $producto->nombre,
            'codigo_barras_snapshot' => $producto->codigo_barras,
            'imagen_snapshot' => $producto->imagen,
        ]);

        // Guarda en la tabla intermedia con snapshots
        $pedido->productos()->attach($producto_id, [
                'cantidad' => $cantidad,
                'precio_unitario' => $precio,
                'subtotal' => $subtotal,
                'nombre_producto_snapshot' => $producto->nombre,
                'codigo_barras_snapshot' => $producto->codigo_barras,
                'imagen_snapshot' => $producto->imagen,
            ]);
        }

        $descuento_aplicado = $subtotal * ($descuento_porcentaje / 100);
        $subtotal_desc = $subtotal - $descuento_aplicado;
        $impuesto = $subtotal_desc * $impuesto_rate;
        $total = $subtotal_desc + $impuesto;


        $pedido->update([
        'subtotal' => $subtotal,
        'descuento' => $descuento_aplicado,
        'impuesto' => $impuesto,
        'total' => $total,
        ]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido guardado correctamente.');
    }

    public function index(){
        $pedidos = Pedido::with(['usuario', 'productos'])->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create(){
        $productos = Producto::all(); // importante para llenar el select
        return view('pedidos.partials.create', compact('productos'));
    }


    public function update(Request $request, $id){
        $pedido = Pedido::findOrFail($id);

        // Obtiene los estados permitidos desde el modelo
        $allowedStates = array_keys($pedido->estadosPermitidos());

        // Valida que el estado esté dentro de los permitidos
        $request->validate([
            'estado_pedido' => ['required', Rule::in($allowedStates)],
        ]);

        // Actualiza el estado del pedido
        $pedido->estado_pedido = $request->estado_pedido;
        $pedido->save();

        return redirect()->route('pedidos.index')->with('success', 'Estado del pedido actualizado correctamente.');
    }

    
}

