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
        Schema::table('produks', function (Blueprint $table) {
            $table->decimal('harga_pokok', 15, 2)->nullable()->after('harga');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('hpp_satuan', 15, 2)->nullable()->after('harga_satuan');
        });

        Schema::table('toko_daily_summaries', function (Blueprint $table) {
            $table->decimal('total_hpp', 15, 2)->default(0)->after('total_revenue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn('harga_pokok');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('hpp_satuan');
        });

        Schema::table('toko_daily_summaries', function (Blueprint $table) {
            $table->dropColumn('total_hpp');
        });
    }
};
