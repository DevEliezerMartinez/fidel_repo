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
        Schema::table('tickets', function (Blueprint $table) {
            // Hacer que la columna 'ticket_pdf' permita valores NULL
            $table->string('ticket_pdf', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            // Revertir el cambio, hacer que 'ticket_pdf' no permita NULL
            $table->string('ticket_pdf', 255)->nullable(false)->change();
        });
    }
};
