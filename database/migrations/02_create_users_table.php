<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 255);
            $table->string('password', 255);
            $table->string('email', 255)->unique()->email();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('contact_number', 20);
            $table->string('user_role', 50)->default('user');
            $table->string('user_photo', 255)->default('default_profile_icon.png')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
