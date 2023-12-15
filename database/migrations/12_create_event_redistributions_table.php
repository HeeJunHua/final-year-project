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
            $table->foreignId('user_id')->constrained();
            $table->string('event_name');
            $table->dateTime('event_date');
            $table->string('location');
            $table->integer('people_quantity');
            $table->text('leftovers_description')->nullable();
            $table->enum('status', ['incomplete','pending', 'approved', 'rejected', 'completed'])->default('incomplete');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_redistributions');
    }
};
