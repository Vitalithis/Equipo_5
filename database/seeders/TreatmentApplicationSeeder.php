<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TreatmentApplication;

class TreatmentApplicationSeeder extends Seeder
{
    public function run(): void
    {
        TreatmentApplication::factory()->count(20)->create();
    }
}
