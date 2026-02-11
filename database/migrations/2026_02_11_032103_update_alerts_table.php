<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('alerts', function (Blueprint $table) {
            // Elimina columnas antiguas
            $table->dropIndex(['alertable_type','alertable_id']);
            
            if (Schema::hasColumn('alerts', 'level')) {
                $table->dropColumn('level');
            }
            if (Schema::hasColumn('alerts', 'alertable_type')) {
                $table->dropColumn('alertable_type');
            }
            if (Schema::hasColumn('alerts', 'alertable_id')) {
                $table->dropColumn('alertable_id');
            }
            if (Schema::hasColumn('alerts', 'data')) {
                $table->dropColumn('data');
            }
            if (Schema::hasColumn('alerts', 'resolved')) {
                $table->dropColumn('resolved');
            }

            // Añade nuevas columnas
            if (!Schema::hasColumn('alerts', 'activovivo_id')) {
                $table->unsignedBigInteger('activovivo_id')->nullable()->after('id');
                $table->foreign('activovivo_id')->references('id')->on('activovivos')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('alerts', 'message')) {
                $table->string('message')->after('type');
            }
            if (!Schema::hasColumn('alerts', 'threshold')) {
                $table->decimal('threshold', 8, 2)->nullable()->after('message');
            }
            if (!Schema::hasColumn('alerts', 'status')) {
                $table->string('status')->default('activo')->after('threshold');
            }
        });
    }

    public function down(): void {
        Schema::table('alerts', function (Blueprint $table) {
            // Elimina nuevas columnas
            if (Schema::hasColumn('alerts', 'activovivo_id')) {
                $table->dropForeign(['activovivo_id']);
                $table->dropColumn('activovivo_id');
            }
            if (Schema::hasColumn('alerts', 'message')) {
                $table->dropColumn('message');
            }
            if (Schema::hasColumn('alerts', 'threshold')) {
                $table->dropColumn('threshold');
            }
            if (Schema::hasColumn('alerts', 'status')) {
                $table->dropColumn('status');
            }

            // Restaura columnas antiguas
            $table->string('level')->default('warning');
            $table->string('alertable_type');
            $table->unsignedBigInteger('alertable_id');
            $table->json('data')->nullable();
            $table->boolean('resolved')->default(false);
        });
    }
};

