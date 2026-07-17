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
            if (Schema::hasColumn('produks', 'kategori')) {
                $table->dropColumn('kategori');
            }
            $table->foreignId('category_id')->nullable()->after('nama_produk')->constrained('categories')->nullOnDelete();
            $table->integer('berat')->default(1000)->after('stok'); // Default 1000 gram
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id', 'berat']);
            $table->string('kategori')->nullable();
        });
    }
};
