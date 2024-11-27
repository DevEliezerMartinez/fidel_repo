<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSeatsReservedTypeInReservationsTable extends Migration
{
    /**
     * Ejecuta la migración.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservation', function (Blueprint $table) {
            // Cambiar el tipo de la columna 'seats_reserved' de 'int' a 'varchar(255)'
            $table->string('seats_reserved', 255)->change();
        });
    }

    /**
     * Revierte la migración.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservation', function (Blueprint $table) {
            // Revertir el cambio de tipo de 'varchar' a 'int'
            $table->integer('seats_reserved')->change();
        });
    }
}
