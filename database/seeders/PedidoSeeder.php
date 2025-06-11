<?php

namespace Database\Seeders;

use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\User;
use Illuminate\Database\Seeder;

class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        // ✅ Crear un usuario si no existe
        $usuario = User::first() ?? User::factory()->create();

        Pedido::factory()
            ->count(10)
            ->create([
                'usuario_id' => $usuario->id // asignar usuario válido
            ])
            ->each(function ($pedido) {
                $totalSubtotal = 0;

                DetallePedido::factory()
                    ->count(rand(1, 5))
                    ->make()
                    ->each(function ($detalle) use ($pedido, &$totalSubtotal) {
                        $detalle->pedido_id = $pedido->id;
                        $detalle->save();

                        $totalSubtotal += $detalle->subtotal;
                    });

                $impuesto = $totalSubtotal * 0.19;
                $descuento = $totalSubtotal * 0.05;
                $totalFinal = $totalSubtotal + $impuesto - $descuento;

                $pedido->update([
                    'subtotal' => $totalSubtotal,
                    'impuesto' => $impuesto,
                    'descuento' => $descuento,
                    'total' => $totalFinal,
                    'monto_pagado' => $pedido->estado_pago === 'pagado' ? $totalFinal : 0,
                ]);
            });
    }
}
