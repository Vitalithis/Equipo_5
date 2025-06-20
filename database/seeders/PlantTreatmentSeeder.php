<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlantTreatment;

class PlantTreatmentSeeder extends Seeder
{
    public function run(): void
    {
        PlantTreatment::factory()->count(20)->create(); // ajusta el número si quieres más registros
    }
}
