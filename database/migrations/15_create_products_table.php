<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_id');
            $table->string('product_name', 255);
            $table->string('product_category', 255);
            $table->text('product_description');
            $table->date('product_expiry_date');
            $table->integer('product_quantity');
            $table->string('product_status', 50);
            $table->timestamps();
            $table->foreign('inventory_id')->references('id')->on('inventories');
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
