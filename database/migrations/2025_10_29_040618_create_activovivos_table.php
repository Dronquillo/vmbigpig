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
        Schema::create('activovivos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->date('fecha_nacemiento');
            $table->time('hora_nacimiento')->nullable();
            $table->integer('numero_camada');
            $table->string('color')->nullable();
            $table->string('especie');
            $table->string('raza')->nullable();
            $table->string('genero')->default('masculino');
            $table->decimal('peso', 8, 2)->nullable();
            $table->unsignedBigInteger('medida_id');
            $table->foreign('medida_id')->references('id')->on('tabla_medidas')->onDelete('cascade');
            $table->string('estado_salud')->nullable();
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categoria_activos')->onDelete('cascade');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->string('estado')->default('activo');
            $table->foreignId('lot_id')->nullable()->constrained('lots')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activovivos');
    }
};
