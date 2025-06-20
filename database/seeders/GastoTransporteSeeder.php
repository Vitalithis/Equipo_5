<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\GastoTransporte;

class GastoTransporteSeeder extends Seeder
{
    public function run(): void
    {
        GastoTransporte::factory()->count(30)->create();
    }
}
