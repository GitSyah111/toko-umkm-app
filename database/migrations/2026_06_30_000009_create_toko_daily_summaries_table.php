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
        Schema::create('toko_daily_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('toko_id')->constrained('tokos')->cascadeOnDelete();
            $table->date('tanggal');
            $table->double('total_revenue')->default(0);
            $table->integer('total_orders')->default(0);
            $table->timestamps();
            
            $table->unique(['toko_id', 'tanggal'], 'idx_toko_daily_date_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toko_daily_summaries');
    }
};
