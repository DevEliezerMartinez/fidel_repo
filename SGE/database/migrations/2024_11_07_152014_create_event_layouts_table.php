<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventLayoutsTable extends Migration
{
    public function up()
    {
        Schema::create('event_layouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->json('layout_json');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_layouts');
    }
}
