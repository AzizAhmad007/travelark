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
        Schema::create('palaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');

            $table->foreignId('tag_id')->references('id')->on('tags');

            $table->foreignId('country_id')->references('id')->on('countries');

            $table->foreignId('city_id')->references('id')->on('cities');

            $table->foreignId('province_id')->references('id')->on('provinces');
            $table->string('palace_name');
            $table->text('image');
            $table->double('price');
            $table->longText('description');
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
        Schema::dropIfExists('palaces');
    }
};
