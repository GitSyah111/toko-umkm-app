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
        Schema::create('platform_daily_summaries', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
            $table->double('total_gmv')->default(0);
            $table->integer('total_orders')->default(0);
            $table->integer('total_active_tokos')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('platform_daily_summaries');
    }
};
