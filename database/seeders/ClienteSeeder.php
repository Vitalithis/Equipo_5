<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $clientes = [
            [
                'nombre' => 'Plantas Editha',
                'subdominio' => 'editha',
                'slug' => 'plantas-editha',
                'email' => 'admin@editha.com',
                'password' => 'editha',
            ],
        ];

        foreach ($clientes as $data) {
            // 1. Crear cliente
            $cliente = Cliente::firstOrCreate([
                'nombre' => $data['nombre'],
            ], [
                'subdominio' => $data['subdominio'],
                'slug' => $data['slug'],
                'activo' => true,
            ]);

            // 2. Crear rol admin
            $rolAdmin = Role::firstOrCreate([
                'name' => 'admin',
                'guard_name' => 'web',
                'cliente_id' => $cliente->id,
            ]);

            // 3. Clonar permisos globales
            $permisosGlobales = Permission::whereNull('cliente_id')->get();
            foreach ($permisosGlobales as $permiso) {
                $nuevo = Permission::firstOrCreate([
                    'name' => $permiso->name,
                    'guard_name' => 'web',
                    'cliente_id' => $cliente->id,
                ]);
                $rolAdmin->givePermissionTo($nuevo);
            }

            // 4. Crear usuario admin
            $usuario = User::firstOrCreate([
                'email' => $data['email'],
            ], [
                'name' => 'Admin ' . $data['nombre'],
                'password' => Hash::make($data['password']),
                'cliente_id' => $cliente->id,
                'must_change_password' => true,
            ]);

            // 5. Asignar rol
            $usuario->assignRole($rolAdmin);
        }

        $this->command->info("Clientes, usuarios admin y permisos creados correctamente.");
    }
}
