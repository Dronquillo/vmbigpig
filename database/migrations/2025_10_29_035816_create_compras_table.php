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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->string('numero_compra')->unique();
            $table->unsignedBigInteger('proveedors_id');
            $table->foreign('proveedors_id')->references('id')->on('proveedors')->onDelete('cascade');
            $table->date('fecha_compra');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas')->onDelete('cascade');
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->decimal('cantidad',10, 2);
            $table->unsignedBigInteger('medida_id');
            $table->foreign('medida_id')->references('id')->on('tabla_medidas')->onDelete('cascade');
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('porc_descuento', 5, 2)->default(0);
            $table->decimal('porc_iva', 5, 2)->default(0);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('impuesto', 10, 2)->default(0);
            $table->decimal('valor_total', 10, 2);
            $table->string('lote')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('notas')->nullable();
            $table->string('estado')->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
