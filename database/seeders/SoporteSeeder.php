<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class SoporteSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear rol soporte
        $role = Role::firstOrCreate([
            'name' => 'soporte',
            'guard_name' => 'web',
        ]);

        // 2. Crear usuario soporte
        $user = User::firstOrCreate([
            'email' => 'soporte@plantaseditha.me',
        ], [
            'name' => 'Soporte',
            'password' => Hash::make('soporte'),
        ]);

        // 3. Asignar rol
        $user->assignRole($role);

        // 4. Asignar permisos (opcional, si usas control por permisos)
        $permisos = [
            'ver panel soporte',
            'gestionar clientes',
        ];

        foreach ($permisos as $perm) {
            $permiso = Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
            $role->givePermissionTo($permiso);
        }
    }
}
