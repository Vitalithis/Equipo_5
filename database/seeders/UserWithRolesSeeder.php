<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserWithRolesSeeder extends Seeder
{
    public function run(): void
    {
        // Asegurar que los roles existan
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        // Crear usuario admin personalizado
        $admin = User::firstOrCreate(
            ['email' => 'admin@editha.com'],
            [
                'name' => 'Editha',
                'password' => bcrypt('editha'),
            ]
        );

        if (!$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

        // Crear algunos usuarios con rol 'user'
        User::factory()
            ->count(3)
            ->create()
            ->each(function ($usuario) use ($userRole) {
                $usuario->assignRole($userRole);
            });

        $this->command->info('Admin y usuarios con roles creados correctamente.');
    }
}
