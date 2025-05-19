<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Verificar si el usuario ya existe
        $user = User::firstOrCreate(
            ['email' => 'superadmin@editha.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('editha'), // cambia esta clave luego en producción
            ]
        );

        // Crear rol si no existe
        $role = Role::firstOrCreate(['name' => 'superadmin']);

        // Asignar rol al usuario si aún no lo tiene
        if (!$user->hasRole('superadmin')) {
            $user->assignRole('superadmin');
            $this->command->info('Rol "superadmin" asignado al usuario.');
        } else {
            $this->command->info('El usuario ya tiene el rol "superadmin".');
        }
    }
}
