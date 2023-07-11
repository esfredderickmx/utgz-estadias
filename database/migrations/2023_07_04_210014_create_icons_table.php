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
        Schema::create('icons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('category_icon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('icon_id');

            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('icon_id')->references('id')->on('icons')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('icons');
        Schema::dropIfExists('icon_category');
    }
};
