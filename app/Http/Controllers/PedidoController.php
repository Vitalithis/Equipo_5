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
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
        ]);

        $subtotal = 0;
        $descuento_porcentaje = floatval($request->descuento_porcentaje) ?: 0;
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
            if (
                empty($producto_id) ||
                !isset($request->cantidad[$i]) ||
                !isset($request->precio_unitario[$i]) ||
                $request->cantidad[$i] <= 0 ||
                $request->precio_unitario[$i] <= 0
            ) {
                continue; // omitir fila incompleta o inválida
            }

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

    public function edit($id){
        $pedido = Pedido::with('detalles.producto')->findOrFail($id);
        $productos = Producto::all();

        return view('pedidos.partials.create', compact('pedido', 'productos'));
    }

    public function destroy($id){
        $pedido = Pedido::findOrFail($id);
        // Opcional: elimina los detalles primero para evitar problemas de integridad
        $pedido->detalles()->delete();

        // Elimina el pedido
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado correctamente.');
    }

    public function update(Request $request, $id){
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
            'descuento_porcentaje' => 'nullable|numeric|min:0|max:100',
        ]);
        $pedido = Pedido::findOrFail($id);

         $subtotal = 0;
        $descuento_porcentaje = floatval($request->descuento_porcentaje) ?: 0;
        $impuesto_rate = 0.19;

        $pedido->update([
            'metodo_entrega' => $request->metodo_entrega,
            'direccion_entrega' => $request->metodo_entrega === 'domicilio' ? $request->direccion_entrega : null,
            'estado_pedido' => $request->estado_pedido,
            'forma_pago' => $request->forma_pago,
            'estado_pago' => $request->estado_pago,
            'monto_pagado' => $request->monto_pagado ?? 0,
            'tipo_documento' => $request->tipo_documento,
            'observaciones' => $request->observaciones,
        ]);

        // Eliminar detalles previos
        $pedido->detalles()->delete();

        // Crear nuevos detalles
        foreach ($request->producto_id as $i => $producto_id) {
            if (empty($producto_id) || $request->cantidad[$i] <= 0) continue;

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

        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado correctamente.');
    }

}
         