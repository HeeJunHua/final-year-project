<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('completion_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('volunteer_id');
            $table->string('name');
            $table->string('email');
            $table->string('role');
            $table->string('skill');
            $table->string('task');
            $table->string('achievement');
            $table->decimal('hour',10,2);
            $table->string('path')->nullable();
            $table->string('status');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completion_forms');
    }
};
