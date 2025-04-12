<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class ProductoCategoriaSeeder extends Seeder
{
    public function run()
    {
        // Obtener todos los productos
        $productos = Producto::all();

        // Para cada producto, asignarle categorías aleatorias
        foreach ($productos as $producto) {
            // Seleccionamos entre 1 y 3 categorías aleatorias para el producto
            $categoriaIds = Categoria::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();

            // Asociamos las categorías seleccionadas al producto
            $producto->categorias()->sync($categoriaIds);
        }
    }
}
