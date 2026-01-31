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
        Schema::create('feed_formulas', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Inicial, Engorde, Finalizado
            $table->text('notes')->nullable();
            $table->timestamps();
        });
        
        Schema::create('feed_formula_items', function (Blueprint $table) { 
            $table->id(); 
            $table->foreignId('feed_formula_id') ->constrained('feed_formulas') ->cascadeOnDelete(); 
            $table->foreignId('producto_id') ->constrained('productos') ->cascadeOnDelete(); 
            $table->decimal('cantidad', 8, 2)->default(0); 
            $table->foreignId('medida_id') ->constrained('tabla_medidas') ->cascadeOnDelete(); 
            $table->decimal('percentage', 5, 2); // 0-100 
            $table->timestamps(); 
            $table->unique(['feed_formula_id','producto_id']); });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feed_formula_items');
        Schema::dropIfExists('feed_formulas');
    }
};
