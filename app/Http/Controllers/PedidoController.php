<?php

namespace App\Http\Controllers;
use App\Mail\PedidoCreado;

use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Producto;

use Illuminate\Support\Facades\Mail;
use App\Mail\EstadoPedidoActualizado;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Http;




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

            'direccion_entrega' => $request->metodo_entrega === 'domicilio' ? 'required|string|max:255' : 'nullable',

        ]);

        $direccionCompleta = $request->direccion_entrega;



        $subtotal = 0;
        $descuento_porcentaje = floatval($request->descuento_porcentaje) ?: 0;
        $impuesto_rate = 0.19;

        // Crear pedido 
        $pedido = Pedido::create([
            'usuario_id' => Auth::id(),
            'metodo_entrega' => $request->metodo_entrega,
            'direccion_entrega' => $direccionCompleta,
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

                
        // Enviar correo de confirmación de pedido
        if ($pedido->usuario && $pedido->usuario->email) {
            Mail::to($pedido->usuario->email)->send(new PedidoCreado($pedido));
        }

        // Enviar correo solo si el usuario tiene email válido
        if ($pedido->usuario && $pedido->usuario->email) {
            Mail::to($pedido->usuario->email)->send(new EstadoPedidoActualizado($pedido));
        }
 




        return redirect()->route('pedidos.index')->with('success', 'Pedido guardado correctamente.');
    }

        public function misCompras()
{
    $pedidos = Pedido::where('usuario_id', auth()->id())->latest()->get();
    return view('shopping.index', compact('pedidos'));
}
public function show(Pedido $pedido)
{
    // Solo permitir ver sus propios pedidos
    if ($pedido->usuario_id!== auth()->id()) {
        abort(403);
    }

    return view('shopping.show', compact('pedido'));
}



public function index(Request $request)
{
    $query = Pedido::with(['usuario', 'productos'])->latest();

    if ($request->filled('estado_pedido')) {
        $query->where('estado_pedido', $request->estado_pedido);
    }

    if ($request->filled('usuario')) {
        $query->whereHas('usuario', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->usuario . '%');
        });
    }

    $pedidos = $query->paginate(10);
    $estados = Pedido::estadosTraducidos(); // 👈 aquí

    return view('pedidos.index', compact('pedidos', 'estados'));
}


    public function create(){
        $productos = Producto::all(); // importante para llenar el select
        return view('pedidos.partials.create', compact('productos'));
    }

    public function edit($id){
        $pedido = Pedido::with('detalles.producto')->findOrFail($id);
        $productos = Producto::all();

         // Variables para llenar inputs separados
        $calle = $numero = $depto = $comuna = $ciudad = '';

        if ($pedido->direccion_entrega) {
            // Supongamos formato: "Calle Numero Depto X, Comuna, Ciudad"
            // Puedes usar regex o explode para separar

            // Separar por coma
            $partes = explode(',', $pedido->direccion_entrega);

            // Primera parte: Calle Numero Depto X
            $primeraParte = trim($partes[0] ?? '');

            // Buscar "Depto " si existe
            if (stripos($primeraParte, 'Depto') !== false) {
                preg_match('/^(.*) (\d+)( Depto (.*))?$/i', $primeraParte, $matches);
                // matches[1]: Calle
                // matches[2]: Numero
                // matches[4]: Depto (opcional)
                $calle = $matches[1] ?? '';
                $numero = $matches[2] ?? '';
                $depto = $matches[4] ?? '';
            } else {
                // Sin depto
                preg_match('/^(.*) (\d+)$/i', $primeraParte, $matches);
                $calle = $matches[1] ?? '';
                $numero = $matches[2] ?? '';
            }

            // Comuna y Ciudad
            $comuna = trim($partes[1] ?? '');
            $ciudad = trim($partes[2] ?? '');
        }

        return view('pedidos.partials.create', compact('pedido', 'productos', 'calle', 'numero', 'depto', 'comuna', 'ciudad'));
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
            'calle' => 'nullable|string',
            'numero' => 'nullable|integer',
            'depto' => 'nullable|string',
            'comuna' => 'nullable|string',
            
        ]);
        $direccionCompleta = null;
        if ($request->metodo_entrega === 'domicilio') {
            $direccionCompleta = trim(
                ($request->calle ?? '') . ' ' .
                ($request->numero ?? '') .
                ($request->depto ? ' Depto ' . $request->depto : '') .  // <-- Aquí está el detalle
                ($request->comuna ? ', ' . $request->comuna : '') .
                ($request->ciudad ? ', ' . $request->ciudad : '')
            );
        }

        $pedido = Pedido::findOrFail($id);

         $subtotal = 0;
        $descuento_porcentaje = floatval($request->descuento_porcentaje) ?: 0;
        $impuesto_rate = 0.19;

        $pedido->update([
            'metodo_entrega' => $request->metodo_entrega,
            'direccion_entrega' => $direccionCompleta,
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

        $pedido->estado_pedido = $request->estado_pedido;
    $pedido->save();

    if ($pedido->cliente && $pedido->cliente->email) {
        Mail::to($pedido->cliente->email)->send(new EstadoPedidoActualizado($pedido));
    }

    return redirect()->back()->with('success', 'Pedido actualizado y cliente notificado.');

    }

    public function actualizarEstado(Request $request, Pedido $pedido)
{
    $request->validate([
        'estado_pedido' => 'required|string',
    ]);

    $pedido->estado_pedido = $request->estado_pedido;
    $pedido->save();

    // Notificación Push vía OneSignal
try {
    Http::withHeaders([
        'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY'),
        'Content-Type'  => 'application/json',
    ])->post('https://onesignal.com/api/v1/notifications', [
        'app_id' => env('ONESIGNAL_APP_ID'),
        'include_external_user_ids' => [(string) $pedido->usuario_id],
        'headings' => ['es' => '📦 Pedido actualizado'],
        'contents' => ['es' => "Tu pedido ahora está en estado: {$pedido->estado_pedido}"],
    ]);
} catch (\Exception $e) {
    \Log::error("Error enviando notificación push: " . $e->getMessage());
}


    // Enviar correo al usuario
    if ($pedido->usuario && $pedido->usuario->email) {
        Mail::to($pedido->usuario->email)->send(new EstadoPedidoActualizado($pedido));
    }

    return redirect()->route('pedidos.index')->with('success', 'Estado actualizado y correo enviado.');
}

    public function resumenMensual(Request $request)
{
    $mes = $request->get('mes');
    if (!$mes) {
        return response()->json(['error' => 'Mes no especificado'], 400);
    }

    $inicio = $mes . '-01 00:00:00';
    $fin = date("Y-m-t 23:59:59", strtotime($inicio));

    $pedidos = Pedido::with('detalles.producto') // cargar detalles y productos
                ->whereBetween('fecha_pedido', [$inicio, $fin])
                ->get();

    $total = $pedidos->sum('total');
    $cantidad = $pedidos->count();

    // Agrupar productos
    $productos = [];

    foreach ($pedidos as $pedido) {
        foreach ($pedido->detalles as $detalle) {
            $id = $detalle->producto_id;
            $nombre = $detalle->producto->nombre ?? 'Producto desconocido';

            if (!isset($productos[$id])) {
                $productos[$id] = [
                    'nombre' => $nombre,
                    'cantidad' => 0,
                    'total' => 0,
                ];
            }

            $productos[$id]['cantidad'] += $detalle->cantidad;
            $productos[$id]['total'] += $detalle->cantidad * $detalle->precio_unitario;
        }
    }

    return response()->json([
        'cantidad' => $cantidad,
        'total' => $total,
        'productos' => array_values($productos), // reindexar
    ]);
}


}
         