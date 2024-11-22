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
        Schema::table('events', function (Blueprint $table) {
            $table->integer('precioInfante')->after('descripcion')->nullable(false);
            $table->integer('precioAdulto')->after('precioInfante')->nullable(false);
            $table->integer('precioMenor')->after('precioAdulto')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['precioInfante', 'precioAdulto', 'precioMenor']);
        });
    }
};
