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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('tag_id');
            $table->bigInteger('country_id');
            $table->bigInteger('city_id');
            $table->bigInteger('province_id');
            $table->string('destination_name');
            $table->double('price');
            $table->longText('description');
            $table->double('private_price');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

            $table->foreign('tag_id')->references('id')->on('tags');

            $table->foreign('country_id')->references('id')->on('countries');

            $table->foreign('city_id')->references('id')->on('cities');

            $table->foreign('province_id')->references('id')->on('provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('destinations');
    }
};
