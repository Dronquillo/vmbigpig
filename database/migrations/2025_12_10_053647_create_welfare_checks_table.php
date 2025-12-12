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
        Schema::create('welfare_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('pig_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->string('condition'); // ventilación, heridas, cojeras, temperatura
            $table->string('severity')->default('low'); // low, medium, high
            $table->text('notes')->nullable();
            $table->boolean('vet_required')->default(false);
            $table->timestamps();
            $table->index(['lot_id','pig_id','date','severity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welfare_checks');
    }
};
