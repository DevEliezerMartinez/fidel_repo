<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    public function run()
    {
        DB::table('events')->insert([
            [
                'space_id' => 1,  // Relación con la tabla 'spaces'
                'name' => 'Conferencia sobre Tecnología',
                'event_date' => now()->addDays(3),  // 3 días después de la fecha actual
                'capacity' => 50,
                'remaining_capacity' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'space_id' => 2,  // Relación con la tabla 'spaces'
                'name' => 'Taller de Marketing Digital',
                'event_date' => now()->addDays(1),  // 7 días después de la fecha actual
                'capacity' => 30,
                'remaining_capacity' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'space_id' => 3,  // Relación con la tabla 'spaces'
                'name' => 'Taller de Turismo Digital',
                'event_date' => now()->addDays(1),  // 7 días después de la fecha actual
                'capacity' => 30,
                'remaining_capacity' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
