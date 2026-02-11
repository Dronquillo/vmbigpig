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
        Schema::create('birth_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('activovivo_id')->constrained()->cascadeOnDelete(); // madre 
            $table->date('date'); 
            $table->integer('litter_size')->default(0); 
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birth_events');
    }
};
