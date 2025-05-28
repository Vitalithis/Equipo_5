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
            PermissionSeeder::class,
            CategoriaSeeder::class,
            DescuentoSeeder::class,
            ProductoSeeder::class,
            ProductoCategoriaSeeder::class,
            PedidoSeeder::class,
            FertilizanteSeeder::class,
            OrdenProduccionSeeder::class,
            CuidadoSeeder::class,
            RolUserSeeder::class,
            FinanzaSeeder::class,
            InsumoSeeder::class,
            ProveedorSeeder::class
        ]);

        // Opcional: Crear usuarios de prueba (si necesitas)
        // \App\Models\User::factory(10)->create();

    }
}
