<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,  
            UserWithRolesSeeder::class,     
            CategoriaSeeder::class,
            DescuentoSeeder::class,
            ProductoSeeder::class,
            ProductoCategoriaSeeder::class,
            PedidoSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();
    }
}
