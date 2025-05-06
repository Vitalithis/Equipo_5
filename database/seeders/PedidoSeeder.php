<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;

class PedidoSeeder extends Seeder
{
    public function run()
    {
        // Crear usuarios
        $user1 = User::factory()->create(['name' => 'Juan Pérez', 'email' => 'juan@example.com']);
        $user2 = User::factory()->create(['name' => 'María López', 'email' => 'maria@example.com']);

        // Crear productos
        $producto1 = Producto::create([
            'nombre' => 'Planta A', 'nombre_cientifico' => 'Plantae A',
            'descripcion' => 'Descripción A', 'precio' => 5000,
            'categoria' => 'Interior', 'codigo_barras' => '1234567890123'
        ]);

        $producto2 = Producto::create([
            'nombre' => 'Planta B', 'nombre_cientifico' => 'Plantae B',
            'descripcion' => 'Descripción B', 'precio' => 7000,
            'categoria' => 'Exterior', 'codigo_barras' => '1234567890124'
        ]);

        $producto3 = Producto::create([
            'nombre' => 'Planta C', 'nombre_cientifico' => 'Plantae C',
            'descripcion' => 'Descripción C', 'precio' => 9000,
            'categoria' => 'Interior', 'codigo_barras' => '1234567890125'
        ]);

        // Crear pedidos
        $pedido1 = Pedido::create([
            'usuario_id' => $user1->id,
            'metodo_entrega' => 'retiro',
            'estado_pedido' => 'pendiente',
            'subtotal' => 12000,
            'descuento' => 0,
            'impuesto' => 2280,
            'total' => 14280,
            'forma_pago' => 'tarjeta',
            'estado_pago' => 'pendiente',
            'monto_pagado' => 0,
            'tipo_documento' => 'boleta'
        ]);

        $pedido2 = Pedido::create([
            'usuario_id' => $user2->id,
            'metodo_entrega' => 'domicilio',
            'direccion_entrega' => 'Calle Falsa 123',
            'estado_pedido' => 'en_preparacion',
            'subtotal' => 14000,
            'descuento' => 0,
            'impuesto' => 2660,
            'total' => 16660,
            'forma_pago' => 'transferencia',
            'estado_pago' => 'parcial',
            'monto_pagado' => 5000,
            'tipo_documento' => 'boleta'
        ]);

        // Crear detalles de pedido
        DetallePedido::create([
            'pedido_id' => $pedido1->id,
            'producto_id' => $producto1->id,
            'cantidad' => 2,
            'precio_unitario' => 5000,
            'subtotal' => 10000,
            'nombre_producto_snapshot' => 'Planta A',
            'codigo_barras_snapshot' => '1234567890123',
            'imagen_snapshot' => 'imagenA.jpg'
        ]);

        DetallePedido::create([
            'pedido_id' => $pedido1->id,
            'producto_id' => $producto2->id,
            'cantidad' => 1,
            'precio_unitario' => 7000,
            'subtotal' => 7000,
            'nombre_producto_snapshot' => 'Planta B',
            'codigo_barras_snapshot' => '1234567890124',
            'imagen_snapshot' => 'imagenB.jpg'
        ]);

        DetallePedido::create([
            'pedido_id' => $pedido2->id,
            'producto_id' => $producto3->id,
            'cantidad' => 2,
            'precio_unitario' => 9000,
            'subtotal' => 18000,
            'nombre_producto_snapshot' => 'Planta C',
            'codigo_barras_snapshot' => '1234567890125',
            'imagen_snapshot' => 'imagenC.jpg'
        ]);
    }
}
