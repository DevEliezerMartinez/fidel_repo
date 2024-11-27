<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservation', function (Blueprint $table) {
            // Hacer que los campos 'adultos', 'infantes' y 'menores' puedan ser NULL
            $table->integer('adultos')->nullable()->after('seats_reserved'); // Permite NULL
            $table->integer('infantes')->nullable()->after('adultos'); // Permite NULL
            $table->integer('menores')->nullable()->after('infantes'); // Permite NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservation', function (Blueprint $table) {
            // Eliminar los campos si se revierte la migración
            $table->dropColumn(['adultos', 'infantes', 'menores']);
        });
    }
};
