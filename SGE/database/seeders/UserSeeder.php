<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Verifica si existen registros en la tabla 'users'
        if (DB::table('users')->exists()) {
            DB::table('users')->truncate();
        }
    
        // Usuarios a insertar
        $users = [
            // Usuarios Master
            [
                'name' => 'Jaime',
                'lastname' => 'Huerta',
                'email' => 'jaime.huerta@mundoimperial.com',
                'role_id' => 3, // Rol Master
                'belongs_to_location' => 1, // Hotel Empiere
            ],
            [
                'name' => 'Andrea',
                'lastname' => 'Salmerón',
                'email' => 'calidadpalacio@mundoimperial.com',
                'role_id' => 3, // Rol Master
                'belongs_to_location' => 2, // Hotel Palacios
            ],
            [
                'name' => 'Karla',
                'lastname' => 'Gallardo',
                'email' => 'calidadpierre-xtasea@mundoimperial.com',
                'role_id' => 3, // Rol Master
                'belongs_to_location' => 3, // Hotel Princess
            ],
            [
                'name' => 'Octavio',
                'lastname' => 'Pileño',
                'email' => 'calidadprincess@mundoimperial.com',
                'role_id' => 3, // Rol Master
                'belongs_to_location' => 3, // Hotel Princess
            ],
    
            // Usuarios Administradores PALACIO
            [
                'name' => 'Antonio',
                'lastname' => 'Reducindo',
                'email' => 'antonio.reducindo@mundoimperial.com',
                'role_id' => 2, // Rol Admin
                'belongs_to_location' => 2, // Hotel Palacios
            ],
            [
                'name' => 'Karla',
                'lastname' => 'Valle',
                'email' => 'karla.valle@mundoimperial.com',
                'role_id' => 2, // Rol Admin
                'belongs_to_location' => 2, // Hotel Palacios
            ],
            [
                'name' => 'Mirian',
                'lastname' => 'Olea',
                'email' => 'mirian.olea@mundoimperial.com',
                'role_id' => 2, // Rol Admin
                'belongs_to_location' => 2, // Hotel Palacios
            ],
    
            // Usuario Anfitrión PALACIO
            [
                'name' => 'Anfitrión',
                'lastname' => 'Palacio',
                'email' => 'anfitrion.palacio@mundoimperial.com',
                'role_id' => 1, // Rol User
                'belongs_to_location' => 2, // Hotel Palacios
            ],
    
            // Usuarios Administradores PRINCESS
            [
                'name' => 'Mónica',
                'lastname' => 'Fandiño',
                'email' => 'monica.fandino@mundoimperial.com',
                'role_id' => 2, // Rol Admin
                'belongs_to_location' => 3, // Hotel Princess
            ],
            [
                'name' => 'Ulises',
                'lastname' => 'Rendón',
                'email' => 'ulises.rendon@mundoimperial.com',
                'role_id' => 2, // Rol Admin
                'belongs_to_location' => 3, // Hotel Princess
            ],
    
            // Usuario Anfitrión PRINCESS
            [
                'name' => 'Anfitrión',
                'lastname' => 'Princess',
                'email' => 'anfitrion.princess@mundoimperial.com',
                'role_id' => 1, // Rol User
                'belongs_to_location' => 3, // Hotel Princess
            ],
    
            // Usuarios Administradores PIERRE
            [
                'name' => 'Andrés',
                'lastname' => 'Olmos',
                'email' => 'andres.olmos@mundoimperial.com',
                'role_id' => 2, // Rol Admin
                'belongs_to_location' => 1, // Hotel Empiere
            ],
            [
                'name' => 'Sandra',
                'lastname' => 'Mota',
                'email' => 'sandra.mota@mundoimperial.com',
                'role_id' => 2, // Rol Admin
                'belongs_to_location' => 1, // Hotel Empiere
            ],
    
            // Usuario Anfitrión PIERRE
            [
                'name' => 'Anfitrión',
                'lastname' => 'Pierre',
                'email' => 'anfitrion.pierre@mundoimperial.com',
                'role_id' => 1, // Rol User
                'belongs_to_location' => 1, // Hotel Empiere
            ],
        ];
    
        // Inserta los usuarios en la base de datos
        foreach ($users as $user) {
            // Genera el username con las primeras letras de name y lastname
            $username = strtolower(substr($user['name'], 0, 1) . substr($user['lastname'], 0, 1));
    
            // Crea el usuario con el username generado y la contraseña
            User::create(array_merge($user, [
                'username' => $username, // Asigna el username generado
                'password' => Hash::make(explode('@', $user['email'])[0]), // Contraseña
            ]));
        }
    }
    
}
