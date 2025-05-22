<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SoporteSeeder extends Seeder
{
    public function run(): void
    {
        // Crear el usuario soporte (global)
        $user = User::firstOrCreate(
            ['email' => 'docampo@ing.ucsc.cl'],
            [
                'name' => 'Soporte General',
                'password' => Hash::make('12345678'),
                'cliente_id' => null,
            ]
        );

        // Crear el rol global 'soporte'
        $soporte = Role::firstOrCreate([
            'name' => 'soporte',
            'guard_name' => 'web',
            'cliente_id' => null,
        ]);

        // Obtener todos los permisos
        $todosLosPermisos = Permission::all();

        // Asignar todos los permisos al rol
        $soporte->syncPermissions($todosLosPermisos);

        // Asignar el rol al usuario
        if (!$user->hasRole('soporte')) {
            $user->assignRole($soporte);
        }

        $this->command->info(" Rol 'soporte' actualizado con todos los permisos y asignado a {$user->email}");
    }
}
