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

        Schema::create('tabla_parto_estados', function (Blueprint $table) { 
            $table->id(); 
            $table->foreignId('id_parto')->constrained('tabla_partos')->cascadeOnDelete(); 
            $table->integer('numero_camada'); 
            $table->string('genero')->default('masculino'); 
            $table->string('estado')->default('vivo'); // vivo|muerto 
            $table->string('observaciones')->nullable(); 
            $table->timestamps(); 
            $table->index(['id_parto', 'numero_camada']); 
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabla_parto_estados');
    }
};
