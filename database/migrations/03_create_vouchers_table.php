<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_code', 255);
            $table->string('voucher_name', 255);
            $table->text('voucher_description');
            $table->integer('voucher_point_value');
            $table->integer('voucher_quantity');
            $table->date('voucher_expiry_date');
            $table->string('voucher_status', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
};
