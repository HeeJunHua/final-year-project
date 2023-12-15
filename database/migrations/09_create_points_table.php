<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('donation_id')->nullable();
            $table->unsignedBigInteger('redemption_id')->nullable();
            $table->integer('point');
            $table->string('transaction_type', 255);
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('donation_id')->references('id')->on('donations');
            $table->foreign('redemption_id')->references('id')->on('redemptions');
        });
    }

    public function down()
    {
        Schema::dropIfExists('points');
    }
};
