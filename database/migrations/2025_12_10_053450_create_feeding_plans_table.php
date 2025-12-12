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
        Schema::create('feeding_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_id')->constrained()->cascadeOnDelete();
            $table->foreignId('feed_formula_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('day_from');
            $table->unsignedInteger('day_to');
            $table->decimal('ration_per_pig_kg', 8, 3);
            $table->timestamps();
            $table->index(['lot_id', 'day_from', 'day_to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_plans');
    }
};
