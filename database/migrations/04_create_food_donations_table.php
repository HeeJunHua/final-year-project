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
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('food_bank_id')->nullable();
            $table->date('food_donation_date');
            $table->enum('food_donation_status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->unsignedBigInteger('total_quantity');
            $table->timestamps();
            $table->timestamp('completed_at')->nullable();

            $table->foreign('food_bank_id')->references('id')->on('food_banks')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_donations');
    }
};

