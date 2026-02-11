<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('feeding_events', function (Blueprint $table) {
            // Elimina columnas antiguas si existen
            // Eliminar índice que usa lot_id y pig_id 
            $table->dropIndex(['lot_id', 'pig_id', 'date']);

            if (Schema::hasColumn('feeding_events', 'lot_id')) {
                $table->dropConstrainedForeignId('lot_id');
            }
            if (Schema::hasColumn('feeding_events', 'pig_id')) {
                $table->dropConstrainedForeignId('pig_id');
            }
            if (Schema::hasColumn('feeding_events', 'ration_target_kg')) {
                $table->dropColumn('ration_target_kg');
            }
            if (Schema::hasColumn('feeding_events', 'ration_actual_kg')) {
                $table->dropColumn('ration_actual_kg');
            }
            if (Schema::hasColumn('feeding_events', 'waste_kg')) {
                $table->dropColumn('waste_kg');
            }
            if (Schema::hasColumn('feeding_events', 'cost_usd')) {
                $table->dropColumn('cost_usd');
            }
            if (Schema::hasColumn('feeding_events', 'composition')) {
                $table->dropColumn('composition');
            }

            // Añade las nuevas columnas
            if (!Schema::hasColumn('feeding_events', 'feeding_plan_id')) {
                $table->foreignId('feeding_plan_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('feeding_events', 'notes')) {
                $table->text('notes')->nullable()->after('date');
            }
            if (!Schema::hasColumn('feeding_events', 'status')) {
                $table->string('status')->default('pendiente')->after('notes');
            }
        });
    }

    public function down(): void {
        Schema::table('feeding_events', function (Blueprint $table) {
            // Revertir cambios: eliminar nuevas columnas
            if (Schema::hasColumn('feeding_events', 'feeding_plan_id')) {
                $table->dropConstrainedForeignId('feeding_plan_id');
            }
            if (Schema::hasColumn('feeding_events', 'notes')) {
                $table->dropColumn('notes');
            }
            if (Schema::hasColumn('feeding_events', 'status')) {
                $table->dropColumn('status');
            }

            // Restaurar columnas antiguas
            $table->foreignId('lot_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('pig_id')->nullable()->constrained('activovivos')->cascadeOnDelete();
            $table->decimal('ration_target_kg', 10, 3);
            $table->decimal('ration_actual_kg', 10, 3);
            $table->decimal('waste_kg', 10, 3)->default(0);
            $table->decimal('cost_usd', 12, 4)->default(0);
            $table->string('composition')->nullable();
        });
    }
};
