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
            $table->integer('precioInfante')->nullable()->change();
            $table->integer('precioAdulto')->nullable()->change();
            $table->integer('precioMenor')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('precioInfante')->nullable(false)->change();
            $table->integer('precioAdulto')->nullable(false)->change();
            $table->integer('precioMenor')->nullable(false)->change();
        });
    }
};
