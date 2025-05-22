<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolUserSeeder extends Seeder
{
    public function run(): void
    {
        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        $usuarios = User::where('email', '!=', 'admin@editha.com')
                        ->whereDoesntHave('roles')
                        ->get();

        foreach ($usuarios as $usuario) {
            $usuario->assignRole($userRole);
        }

        $this->command->info(" Rol 'user' creado y asignado a usuarios sin rol (excepto admin).");
    }
}
