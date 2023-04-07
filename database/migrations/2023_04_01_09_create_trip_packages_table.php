<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->references('id')->on('users');
            $table->foreignId('destination_id')->references('id')->on('destinations');
            $table->foreignId('guide_id')->references('id')->on('guides');
            $table->enum('type',['open','private']);
            $table->integer('duration');
            $table->integer('quota');
            $table->dateTime('departure_time');
            $table->double('price');
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
        Schema::dropIfExists('trip_packages');
    }
};
