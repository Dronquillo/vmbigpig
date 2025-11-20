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
            $table->unsignedBigInteger('id_parto');
            $table->foreign('id_parto')->references('id')->on('tabla_partos')->onDelete('cascade');
            $table->integer('numero_camada');
            $table->string('genero')->default('masculino');
            $table->string('estado')->default('vivo');
            $table->string('observaciones')->nullable();
            $table->timestamps();
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
