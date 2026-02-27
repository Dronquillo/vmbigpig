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
        
        Schema::create('controles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_id')->constrained('lots')->cascadeOnDelete();
            $table->foreignId('activovivo_id')->nullable()->constrained('activovivos')->cascadeOnDelete();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->enum('tipo', ['alimentacion','monta','parto','peso','chequeo','alerta']);
            $table->text('descripcion')->nullable();
            $table->decimal('cantidad', 8, 2)->nullable(); // ej. kilos de alimento
            $table->decimal('costo', 8, 2)->nullable();    // costo calculado
            $table->date('fecha');
            $table->time('hora')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controles');
    }
};
