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
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('period_id');
            $table->enum('kind', ['first', 'second']);
            $table->enum('status', ['no_started', 'in_progress', 'approved', 'deprecated'])->default('no_started');
            $table->timestamps();

            $table->foreign('period_id')->references('id')->on('periods')->cascadeOnUpdate()->cascadeOnDelete();
        });

        Schema::create('user_process', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('process_id');
            $table->enum('attempt', ['one', 'two', 'three']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('process_id')->references('id')->on('processes')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processes');
        Schema::dropIfExists('user_process');
    }
};
