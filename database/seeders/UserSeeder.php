<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@editha.com'],
            [
                'name' => 'Admin Editha',
                'password' => Hash::make('password'),
                'cliente_id' => null,
            ]
        );
    }
} 