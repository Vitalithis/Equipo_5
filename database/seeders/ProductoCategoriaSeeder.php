<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoCategoriaSeeder extends Seeder
{
    public function run()
    {
        $productos = Producto::all();

        foreach ($productos as $producto) {
            // Asignar 1-3 categorías aleatorias a cada producto
            $categoriasIds = \App\Models\Categoria::inRandomOrder()
                ->take(rand(1, 3))
                ->pluck('id')
                ->toArray();

            $producto->categorias()->sync($categoriasIds);
        }
    }
}
