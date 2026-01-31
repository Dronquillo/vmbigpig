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
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // stock_low, weight_stall, welfare_high
            $table->string('level')->default('warning'); // info, warning, critical
            $table->morphs('alertable'); // alertable_type + alertable_id
            $table->json('data')->nullable();
            $table->boolean('resolved')->default(false);
            $table->timestamps();
            $table->index(['type','level','resolved']);
        });

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->unsignedBigInteger('model_id');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action'); // created, updated, deleted
            $table->json('payload')->nullable();
            $table->timestamps();
            $table->index(['model','model_id','action','user_id']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('alerts');
    }
};
