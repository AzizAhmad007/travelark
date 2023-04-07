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
        Schema::create('trippackages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('created_by');
            $table->enum('type',['open','private']);
            $table->bigInteger('destination_id');
            $table->bigInteger('guide_id');
            $table->integer('duration');
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
        Schema::dropIfExists('trippackages');
    }
};
