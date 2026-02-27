<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('controles', function (Blueprint $table) {
            // Tipo de inseminación/monta
            $table->string('tipo_inseminacion')->nullable()->after('hora');
            
            // Fecha aproximada de preñez
            $table->date('fecha_preñez')->nullable()->after('tipo_inseminacion');
            
            // Cerdo macho que montó (opcional)
            $table->foreignId('macho_id')
                  ->nullable()
                  ->constrained('activovivos')
                  ->after('fecha_preñez');
        });
    }

    public function down(): void
    {
        Schema::table('controles', function (Blueprint $table) {
            $table->dropConstrainedForeignId('macho_id');
            $table->dropColumn(['tipo_inseminacion','fecha_preñez']);
        });
    }
};

