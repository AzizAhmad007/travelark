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
        Schema::create('checkout_instant_travel_sumaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('palace_id')->references('id')->on('palaces');
            $table->string('transaction_number')->unique();
            $table->double('total_price');
            $table->dateTime('ticket_date');
            $table->integer('qty');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->string('phone_number');
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
        Schema::dropIfExists('checkout_instant_travel_sumaries');
    }
};
