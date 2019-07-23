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
        Schema::create('flights', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('sn');
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

        Schema::create('drains', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('battery_id')->unsigned();
            $table->foreign('battery_id')->references('id')->on('batteries')->onDelete('cascade');
            $table->decimal('percent', 4, 2);
            $table->decimal('temperature', 8, 2);
            $table->timestamps();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
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
        Schema::dropIfExists('batteries');
        Schema::dropIfExists('drains');
        Schema::dropIfExists('locations');
    }
}
