<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniqueFromUsernameInUsers extends Migration
{
    public function up()
    {
        // Eliminar la restricción de unicidad en el campo 'username'
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']); // Esto elimina la restricción UNIQUE en 'username'
        });
    }

    public function down()
    {
        // En caso de revertir la migración, volver a agregar la restricción UNIQUE en 'username'
        Schema::table('users', function (Blueprint $table) {
            $table->unique('username'); // Esto agrega la restricción UNIQUE en 'username'
        });
    }
}
