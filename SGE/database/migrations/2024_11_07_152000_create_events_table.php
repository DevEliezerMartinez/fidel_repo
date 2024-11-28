<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('space_id');
            $table->foreign('space_id')->references('id')->on('spaces')->onDelete('cascade');
            $table->string('name');
            $table->dateTime('event_date');
            $table->integer('capacity');
            $table->integer('remaining_capacity');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}

