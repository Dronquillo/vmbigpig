<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void { 
        Schema::table('feeding_plans', function (Blueprint $table) { 
            if (!Schema::hasColumn('feeding_plans', 'lot_id')) { 
                $table->foreignId('lot_id')->after('id')->constrained('lots')->cascadeOnDelete(); 
                } 
            }); 
        } 
        
    public function down(): void { 
        Schema::table('feeding_plans', function (Blueprint $table) { 
            if (Schema::hasColumn('feeding_plans', 'lot_id')) { 
                $table->dropConstrainedForeignId('lot_id'); 
                } 
            }); 
        }
    
    
};
