<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LocationSeeder extends Seeder
{
    public function run()
    {
        // Insertando algunos datos de ejemplo en la tabla location
        DB::table('location')->insert([
            [
                'id' => 1,
                'name' => 'Ubicación 1',
                'administrator' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Ubicación 2',
                'administrator' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
