<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llama a RoleSeeder primero
        $this->call(RoleSeeder::class);

        // Luego llama a UserSeeder
        $this->call(UserSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(SpaceSeeder::class);
        $this->call(EventSeeder::class);
    }
}
