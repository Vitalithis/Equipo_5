<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Cliente;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run()
    {
        $cliente = Cliente::where('slug', 'plantaseditha')->first();

        if (!$cliente) {
            $this->command->warn(' Cliente plantaseditha no encontrado. Asegúrate de ejecutar ClienteSeeder primero.');
            return;
        }

        // Crear categorías con cliente_id
        $categorias = [
            'Suculenta',
            'Interior',
            'Exterior',
            'Medicinal',
            'Árbol',
            'Decorativa'
        ];

        foreach ($categorias as $nombre) {
            Categoria::create([
                'nombre' => $nombre,
                'cliente_id' => $cliente->id,
            ]);
        }

        $this->command->info(' Categorías creadas exitosamente para el cliente: ' . $cliente->nombre);
    }
}
