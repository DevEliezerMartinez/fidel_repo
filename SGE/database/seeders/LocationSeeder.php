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
                'name' => 'Hotel Empiere',
                'color' => '#05755F',
                'administrator' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Hotel Palacios',
                'color' => '#3989B5',
                'administrator' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Hotel Princess',
                'color' => '#FB537F',
                'administrator' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
