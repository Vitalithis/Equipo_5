<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition(): array
    {
        $usuario = User::inRandomOrder()->first();

        return [
            'usuario_id' => $usuario?->id ?? User::factory(), // usa uno existente o crea uno nuevo
            'metodo_entrega' => $this->faker->randomElement(['retiro', 'domicilio']),
            'direccion_entrega' => $this->faker->address,
            'estado_pedido' => $this->faker->randomElement([
                'pendiente', 'en_preparacion', 'en_camino', 'enviado', 'entregado', 'listo_para_retiro'
            ]),
            'subtotal' => 0,
            'descuento' => 0,
            'impuesto' => 0,
            'total' => 0,
            'forma_pago' => $this->faker->randomElement(['efectivo', 'tarjeta', 'transferencia']),
            'estado_pago' => $this->faker->randomElement(['pendiente', 'pagado', 'reembolsado', 'parcial']),
            'monto_pagado' => 0,
            'tipo_documento' => 'boleta',
            'documento_generado' => false,
            'observaciones' => $this->faker->sentence,
            'boleta_final_path' => null,
        ];
    }
}
