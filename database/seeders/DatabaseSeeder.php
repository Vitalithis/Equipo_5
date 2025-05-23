<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            CategoriaSeeder::class,
            DescuentoSeeder::class,
            ProductoSeeder::class,
            ProductoCategoriaSeeder::class,
            PedidoSeeder::class,
        ]);

        // Opcional: Crear usuarios de prueba (si necesitas)
        // \App\Models\User::factory(10)->create();

    }
}
