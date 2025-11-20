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
            $table->date('fecha');
            $table->unsignedBigInteger('id_activo');
            $table->foreign('id_activo')->references('id')->on('activovivos')->onDelete('cascade');
            $table->integer('numero_camada');
            $table->date('fecha_servicio');
            $table->time('hora_servicio');
            $table->string('reproductor');
            $table->date('fecha_parto');
            $table->time('hora_parto');
            $table->unsignedBigInteger('id_personal');
            $table->foreign('id_personal')->references('id')->on('personals')->onDelete('cascade');
            $table->integer('numero_crias');
            $table->string('observaciones')->nullable();
            $table->string('estado')->default('activo');
            $table->timestamps();
            
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
