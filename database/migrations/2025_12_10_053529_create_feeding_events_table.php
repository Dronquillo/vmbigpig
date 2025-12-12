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
        Schema::create('feeding_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('pig_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->decimal('ration_target_kg', 10, 3);
            $table->decimal('ration_actual_kg', 10, 3);
            $table->decimal('waste_kg', 10, 3)->default(0);
            $table->decimal('cost_usd', 12, 4)->default(0);
            $table->json('composition')->nullable();
            $table->timestamps();
            $table->index(['lot_id', 'pig_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeding_events');
    }
};
