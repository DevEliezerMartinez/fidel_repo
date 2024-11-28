<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Desactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Vaciar la tabla 'roles'
        DB::table('roles')->truncate();

        // Reactivar restricciones de claves foráneas
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Insertar los roles predeterminados
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'user', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'master', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
