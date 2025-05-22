<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ProductoCategoriaSeeder extends Seeder
{
    public function run()
    {
        $cliente = Cliente::where('slug', 'plantaseditha')->first();

        if (!$cliente) {
            $this->command->warn('Cliente plantaseditha no encontrado. Ejecuta ClienteSeeder primero.');
            return;
        }

        $productos = Producto::where('cliente_id', $cliente->id)->get();

        foreach ($productos as $producto) {
            // Seleccionar categorías que pertenezcan al mismo cliente
            $categoriasIds = Categoria::where('cliente_id', $cliente->id)
                ->inRandomOrder()
                ->take(rand(1, 3))
                ->pluck('id')
                ->toArray();

            $producto->categorias()->sync($categoriasIds);
        }

        $this->command->info('Categorías asignadas a productos correctamente para el cliente: ' . $cliente->nombre);
    }
}
