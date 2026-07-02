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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('toko_id')->constrained('tokos');
            $table->dateTime('tanggal_order');
            $table->string('status');
            $table->double('total_harga');
            $table->double('ongkir');
            $table->double('total_bayar');
            $table->text('alamat_pengiriman');
            $table->string('resi_pengiriman')->nullable();
            $table->text('alasan_pembatalan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
