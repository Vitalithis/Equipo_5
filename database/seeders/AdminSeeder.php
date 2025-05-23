<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@editha.com'],
            [
                'name' => 'Editha',
                'password' => Hash::make('editha'), 
            ]
        );

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin->syncPermissions(Permission::all());

        if (!$user->hasRole($admin->name)) {
            $user->assignRole($admin);
            $this->command->info(" Rol '{$admin->name}' asignado al usuario.");
        } else {
            $this->command->info("ℹEl usuario ya tiene el rol '{$admin->name}'.");
        }
    }
}
