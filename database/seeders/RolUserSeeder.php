<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear el rol "user" si no existe
        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        // 2. Obtener todos los usuarios sin roles, excepto el superadmin
        $usuarios = User::where('email', '!=', 'superadmin@editha.com')
                        ->whereDoesntHave('roles')
                        ->get();

        // 3. Asignarles el rol "user"
        foreach ($usuarios as $usuario) {
            $usuario->assignRole($userRole);
        }

        $this->command->info("Rol 'user' creado y asignado a usuarios sin rol (excepto superadmin).");
    }
}
