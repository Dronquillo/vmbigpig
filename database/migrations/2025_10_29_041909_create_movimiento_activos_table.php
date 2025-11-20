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
        Schema::create('movimiento_activos', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->date('fecha');
            $table->unsignedBigInteger('activo_id');
            $table->foreign('activo_id')->references('id')->on('activovivos')->onDelete('cascade');
            $table->decimal('peso', 8, 2)->nullable();
            $table->unsignedBigInteger('actmed_id');
            $table->foreign('actmed_id')->references('id')->on('tabla_medidas')->onDelete('cascade');
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->decimal('cantidad', 10, 2);
            $table->unsignedBigInteger('medida_id');
            $table->foreign('medida_id')->references('id')->on('tabla_medidas')->onDelete('cascade');
            $table->unsignedBigInteger('movimiento_id');
            $table->foreign('movimiento_id')->references('id')->on('tabla_movimientos')->onDelete('cascade');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->string('estado')->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_activos');
    }
};
