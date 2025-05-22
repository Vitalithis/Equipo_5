<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class ProductoCategoriaSeeder extends Seeder
{
    public function run()
    {
        $productos = Producto::all();
        $categorias = Categoria::all();

        foreach ($productos as $producto) {
            $categoriasIds = $categorias
                ->random(rand(1, min(3, $categorias->count())))
                ->pluck('id')
                ->toArray();

            $producto->categorias()->sync($categoriasIds);
        }

        $this->command->info('Categorías asignadas a productos correctamente.');
    }
}
