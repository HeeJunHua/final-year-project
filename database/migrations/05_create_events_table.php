<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id');
            $table->string('event_name', 255);
            $table->text('event_description');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('event_location', 255);
            $table->decimal('target_goal', 10, 2);
            $table->string('event_status', 50);
            $table->string('cover_image', 255)->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
};
