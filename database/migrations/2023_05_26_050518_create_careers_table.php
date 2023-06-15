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
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_id');
            $table->string('name');
            $table->string('context')->nullable();
            $table->enum('grade', ['technician', 'higher']);
            $table->enum('availability', ['week', 'weekend', 'both']);
            $table->text('image')->unique();
            $table->timestamps();

            $table->foreign('area_id')->references('id')->on('areas')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};
