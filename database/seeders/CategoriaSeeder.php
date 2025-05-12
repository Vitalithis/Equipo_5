<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        // Crear algunas categorías de ejemplo
        Categoria::create(['nombre' => 'Suculenta']);
        Categoria::create(['nombre' => 'Interior']);
        Categoria::create(['nombre' => 'Exterior']);
        Categoria::create(['nombre' => 'Medicinal']);
        Categoria::create(['nombre' => 'Árbol']);
        Categoria::create(['nombre' => 'Decorativa']);


        $this->command->info('Categorias creadas exitosamente.');
    }
}
