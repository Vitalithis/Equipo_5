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
        $soporte = User::firstOrCreate([
            'email' => 'admin@dan.cl',
        ], [
            'name' => 'Dan Ocampo',
            'password' => Hash::make('12345678'),
            'cliente_id' => null,
        ]);

        $rolSoporte = Role::firstOrCreate([
            'name' => 'soporte',
            'guard_name' => 'web',
            'cliente_id' => null,
        ]);

        $rolSoporte->syncPermissions([
            'ver panel soporte',
            'crear cliente',
            'ver dashboard',
            'gestionar clientes'
        ]);

        $soporte->assignRole($rolSoporte);
    }
}
