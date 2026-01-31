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

        Schema::create('tabla_partos', function (Blueprint $table) { 
            $table->id();  
            $table->foreignId('id_activo')->constrained('activovivos')->cascadeOnDelete(); 
            $table->integer('numero_camada')->nullable(); 
            $table->string('reproductor')->nullable(); 
            $table->date('fecha_parto'); 
            $table->time('hora_parto')->nullable(); 
            $table->foreignId('id_personal')->constrained('personals')->cascadeOnDelete(); 
            $table->integer('numero_crias'); 
            $table->string('observaciones')->nullable(); 
            $table->string('estado')->default('activo'); 
            $table->timestamps(); 
            $table->index(['id_activo', 'fecha_parto']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabla_partos');
    }
};
