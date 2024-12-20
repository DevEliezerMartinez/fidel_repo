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
            $table->string('name')->after('event_id'); // Añade la columna 'name' después de 'event_id'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservation', function (Blueprint $table) {
            $table->dropColumn('name'); // Elimina la columna 'name' en caso de rollback
        });
    }
};
