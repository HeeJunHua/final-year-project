<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('points_earned');
            $table->decimal('donation_amount', 10, 2);
            $table->string('payment_method', 50);
            $table->date('donation_date');
            $table->string('name', 255);
            $table->string('phone', 255);
            $table->string('email', 255);
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('donations');
    }
};
