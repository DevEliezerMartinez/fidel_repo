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
                'name' => 'Hotel Mundo imperial',
                'administrator' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Hotel Pierre',
                'administrator' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
