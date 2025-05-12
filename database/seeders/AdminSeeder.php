<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear Super Admin si no existe
        if (\App\Models\User::where('email', 'superadmin@editha.com')->doesntExist()) {
            \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@editha.com',
            'password' => \Illuminate\Support\Facades\Hash::make('editha'), // Cambia esta contraseña
            'role' => 'superadmin'
            ]);

        $this->command->info('¡Super usuario creado exitosamente!');
        }else {
            $this->command->info('El super usuario ya existe o error al añadir.');
        }
    }
}
