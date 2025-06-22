<?php

namespace Database\Seeders;

use App\Models\CalendarEvent;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CalendarEventSeeder extends Seeder
{
    public function run(): void
    {
        CalendarEvent::create([
            'title' => 'Ruda en almácigo',
            'type' => 'siembra',
            'start_date' => Carbon::now()->addDays(2),
            'producto_id' => 1, // Asegúrate que este producto exista
        ]);

        CalendarEvent::create([
            'title' => 'Trasplante de Lavanda',
            'type' => 'transplante',
            'start_date' => Carbon::now()->addDays(7),
            'producto_id' => 2, // Asegúrate que este producto exista
        ]);
    }
}