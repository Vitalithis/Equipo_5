<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use App\Models\Cliente;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $cliente = Cliente::where('slug', 'plantaseditha')->first();

        if (!$cliente) {
            $this->command->warn('Cliente plantaseditha no encontrado. Ejecuta ClienteSeeder primero.');
            return;
        }

        $this->command->info('Echando a correr factory de productos para el cliente: ' . $cliente->nombre);

        Producto::factory()
            ->count(20)
            ->create([
                'cliente_id' => $cliente->id,
            ]);

        $this->command->info('Productos creados exitosamente.');
    }
}
