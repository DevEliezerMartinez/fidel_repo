<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpaceSeeder extends Seeder
{
    public function run()
    {
        DB::table('spaces')->insert([
            [
                'name' => 'Sala A',
                'description' => 'Espacio para conferencias y eventos',
                'id_location' => 1,  // Aquí debe ser el ID de una ubicación existente en la tabla `locations`
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sala B',
                'description' => 'Espacio para talleres y reuniones',
                'id_location' => 2,  // Aquí debe ser el ID de otra ubicación existente
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
