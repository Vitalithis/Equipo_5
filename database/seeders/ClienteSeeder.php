<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        // Crear el cliente
        $cliente = Cliente::firstOrCreate(
            ['slug' => 'plantaseditha'],
            ['nombre' => 'Plantaseditha']
        );

        // Crear el usuario admin si no existe
        $user = User::firstOrCreate(
            ['email' => 'admin@editha.com'],
            [
                'name' => 'Editha',
                'password' => Hash::make('editha'),
                'cliente_id' => $cliente->id,
            ]
        );

        // Asegurar que el usuario tenga cliente_id asignado
        if (!$user->cliente_id) {
            $user->cliente_id = $cliente->id;
            $user->save();
        }

        // Crear el rol admin para ese cliente
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
            'cliente_id' => $cliente->id,
        ]);

        // Crear también el rol 'user' para ese cliente
        $userRole = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'web',
            'cliente_id' => $cliente->id,
        ]);

        // Asignar el rol admin al usuario (si no lo tiene aún)
        if (!$user->hasRole('admin')) {
            $user->assignRole($adminRole);
        }

        $this->command->info("Cliente '{$cliente->nombre}' y roles 'admin' y 'user' creados correctamente.");
    }
}
