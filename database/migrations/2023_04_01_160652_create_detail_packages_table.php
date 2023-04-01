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
        Schema::create('detail_packages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->longText('desciption');
            $table->integer('quota');
            $table->dateTime('departure_time');
            $table->double('total_price');
            $table->bigInteger('trip_packages_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

            $table->foreign('trip_packages_id')->references('id')->on('trip_packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_packages');
    }
};
