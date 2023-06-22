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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('career_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->unsignedBigInteger('control_number')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->string('phone');
            $table->enum('type', ['ordinal', 'repeater', 'burned'])->nullable();
            $table->enum('role', ['student', 'adviser', 'manager', 'admin', 'super'])->default('student');
            $table->timestamps();

            $table->foreign('area_id')->references('id')->on('areas')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('career_id')->references('id')->on('careers')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
