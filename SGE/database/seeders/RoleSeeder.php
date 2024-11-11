<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Verificar si existen registros en la tabla 'roles'
        if (DB::table('roles')->exists()) {
            // Vaciar la tabla 'roles' si ya tiene datos
            DB::table('roles')->truncate();
        }

        // Insertar los roles predeterminados (user, admin, master)
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'user', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'master', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
