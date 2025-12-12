<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.Lotes
     */
    public function up(): void
    {
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barn_id')->constrained()->cascadeOnDelete();
            $table->string('code')->unique();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->unsignedInteger('initial_count');
            $table->unsignedInteger('current_count');
            $table->timestamps();
            $table->index(['barn_id', 'start_date']);            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
