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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('process_id');
            $table->integer('number');
            $table->text('instructions');
            $table->enum('status', ['pending', 'reviewing', 'rejected', 'approved'])->default('pending');
            $table->date('limit_date');
            $table->timestamps();

            $table->foreign('process_id')->references('id')->on('processes')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
