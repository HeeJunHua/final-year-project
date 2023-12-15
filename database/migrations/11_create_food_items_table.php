<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('food_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('food_item_name', 255);
            $table->string('food_item_category', 255);
            $table->unsignedInteger('food_item_quantity');
            $table->boolean('has_expiry_date');
            $table->date('food_item_expiry_date')->nullable();
            $table->boolean('donated')->default(false);
            $table->unsignedBigInteger('itemable_id')->nullable();
            $table->string('itemable_type',100)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('food_items');
    }
};