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
        Schema::create('weight_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pig_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('lot_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->decimal('weight_kg', 8, 3);
            $table->timestamps();
            $table->index(['lot_id', 'pig_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weight_records');
    }
};
