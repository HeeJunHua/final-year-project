<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('event_redistributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Relationship with users
            $table->string('event_name');
            $table->dateTime('event_date');
            $table->string('location');
            $table->enum('food_amount_unit', ['quantity', 'kg'])->default('quantity');
            $table->float('food_amount');
            $table->integer('people_quantity');
            $table->text('leftovers_description')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_redistributions');
    }
};
