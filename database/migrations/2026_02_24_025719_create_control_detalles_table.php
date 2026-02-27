<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('control_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('control_id')->constrained('controles')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos');
            $table->integer('cantidad');
            $table->decimal('precio',10,2);
            $table->decimal('subtotal',10,2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('control_detalles');
    }

};
