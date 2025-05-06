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
        // Crear Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@editha.com',
            'password' => Hash::make('editha'), // Cambia esta contraseña
            'role' => 'superadmin'
        ]);


        $this->call([
            CategoriaSeeder::class,
            ProductoSeeder::class,
            ProductoCategoriaSeeder::class,
        ]);

        // Opcional: Crear usuarios de prueba (si necesitas)
        // \App\Models\User::factory(10)->create();

    }
}