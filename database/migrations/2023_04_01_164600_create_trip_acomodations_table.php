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
        Schema::create('trip_acomodations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('trip_package_id');
            $table->timestamps();

            $table->foreign('trip_package_id')->references('id')->on('trip_packages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_acomodations');
    }
};
