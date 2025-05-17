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
            'producto_id' => 'required|array',
            'producto_id.*' => 'exists:productos,id',
            'cantidad' => 'required|array',
            'precio_unitario' => 'required|array',
        ]);

        $total = 0;

        // Crea el pedido
        $pedido = Pedido::create([
            'usuario_id' => Auth::id(),
            'metodo_entrega' => $request->metodo_entrega,
            'estado_pedido' => $request->estado_pedido,
            'total' => 0, // temporal
        ]);

        foreach ($request->producto_id as $i => $producto_id) {
            $cantidad = $request->cantidad[$i];
            $precio = $request->precio_unitario[$i];
            $subtotal = $cantidad * $precio;
            $total += $subtotal;

            $producto = Producto::findOrFail($producto_id);

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

        // Actualiza el total del pedido
        $pedido->update(['total' => $total]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado correctamente.');
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

