<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('food_donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('food_item_id');
            $table->date('food_donation_date');
            $table->string('food_donation_status', 50);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('food_item_id')->references('id')->on('food_items')->onDelete('cascade');
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_donations');
    }
};
