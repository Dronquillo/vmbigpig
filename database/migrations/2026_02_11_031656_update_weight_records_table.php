<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('weight_records', function (Blueprint $table) {
            // Elimina columnas antiguas si existen
            $table->dropIndex(['lot_id', 'pig_id', 'date']);
            
            if (Schema::hasColumn('weight_records', 'pig_id')) {
                $table->dropConstrainedForeignId('pig_id');
            }
            if (Schema::hasColumn('weight_records', 'lot_id')) {
                $table->dropConstrainedForeignId('lot_id');
            }
            if (Schema::hasColumn('weight_records', 'weight_kg')) {
                $table->dropColumn('weight_kg');
            }

            // Añade las nuevas columnas
            if (!Schema::hasColumn('weight_records', 'activovivo_id')) {
                $table->foreignId('activovivo_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('weight_records', 'weight')) {
                $table->decimal('weight', 8, 2)->after('date');
            }
            if (!Schema::hasColumn('weight_records', 'medida_id')) {
                $table->foreignId('medida_id')->nullable()->after('weight')->constrained('tabla_medidas');
            }
        });
    }

    public function down(): void {
        Schema::table('weight_records', function (Blueprint $table) {
            // Revertir cambios: eliminar nuevas columnas
            if (Schema::hasColumn('weight_records', 'activovivo_id')) {
                $table->dropConstrainedForeignId('activovivo_id');
            }
            if (Schema::hasColumn('weight_records', 'weight')) {
                $table->dropColumn('weight');
            }
            if (Schema::hasColumn('weight_records', 'medida_id')) {
                $table->dropConstrainedForeignId('medida_id');
            }

            // Restaurar columnas antiguas
            $table->foreignId('pig_id')->nullable()->constrained('activovivos')->cascadeOnDelete();
            $table->foreignId('lot_id')->nullable()->constrained()->cascadeOnDelete();
            $table->decimal('weight_kg', 8, 3);
        });
    }
};
