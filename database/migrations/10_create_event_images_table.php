<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('event_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->string('image_path', 255);
            $table->timestamps();

            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_images');
    }
};
