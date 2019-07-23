<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Flights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aircrafts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('sn');
            $table->timestamps();
        });

        Schema::create('flights', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('aircraft_id')->unsigned();
            $table->foreign('aircraft_id')->references('id')->on('aircrafts')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('batteries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('flight_id');
            $table->foreign('flight_id')->references('id')->on('flights')->onDelete('cascade');
            $table->string('name');
            $table->string('sn');
            $table->timestamps();
        });

        Schema::create('frames', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('flight_id');
            $table->foreign('flight_id')->references('id')->on('flights')->onDelete('cascade');
            $table->point('location')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights');
        Schema::dropIfExists('aircrafts');
        Schema::dropIfExists('batteries');
    }
}
