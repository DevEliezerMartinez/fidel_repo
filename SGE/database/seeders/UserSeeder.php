<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Verifica si existen registros en la tabla 'users'
        if (DB::table('users')->exists()) {
            // Vacía la tabla 'users' si ya tiene datos
            DB::table('users')->truncate();
        }

        // Crea un usuario de prueba con un rol existente
        User::factory()->create([
            'name' => 'Fidel Jesus',
            'lastname' => 'Pascual',
            'email' => 'fidel@gmail.com',
            'username' => 'FJ',
            'role_id' => 1, // Asegúrate de que este ID exista en RoleSeeder
        ]);
    }
}
