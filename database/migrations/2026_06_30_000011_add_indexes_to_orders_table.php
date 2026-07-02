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
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['toko_id', 'tanggal_order', 'status'], 'idx_orders_toko_date_status');
            $table->index(['tanggal_order', 'status'], 'idx_orders_date_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_orders_toko_date_status');
            $table->dropIndex('idx_orders_date_status');
        });
    }
};
