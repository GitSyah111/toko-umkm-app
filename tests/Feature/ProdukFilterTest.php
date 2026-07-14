<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Toko;
use App\Models\Produk;

class ProdukFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_filter_produk_berdasarkan_nama_kategori_dan_harga(): void
    {
        $seller = User::create([
            'name' => 'Seller Test',
            'email' => 'seller@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'penjual'
        ]);

        $toko = Toko::create([
            'user_id' => $seller->id,
            'nama_toko' => 'Toko Test',
            'deskripsi' => 'Deskripsi',
        ]);

        $produk1 = Produk::create([
            'toko_id' => $toko->id,
            'nama_produk' => 'Sepatu Olahraga',
            'kategori' => 'Pakaian',
            'harga' => 150000,
            'stok' => 10,
            'status' => 'aktif'
        ]);

        $produk2 = Produk::create([
            'toko_id' => $toko->id,
            'nama_produk' => 'Buku Pemrograman',
            'kategori' => 'Buku',
            'harga' => 80000,
            'stok' => 5,
            'status' => 'aktif'
        ]);

        $produk3 = Produk::create([
            'toko_id' => $toko->id,
            'nama_produk' => 'Sepatu Kulit',
            'kategori' => 'Pakaian',
            'harga' => 250000,
            'stok' => 2,
            'status' => 'aktif'
        ]);

        $this->actingAs($seller);

        // 1. Test Pencarian berdasarkan nama produk
        $response = $this->get(route('seller.produk.index', ['search' => 'sepatu']));
        $response->assertStatus(200);
        $response->assertSee('Sepatu Olahraga');
        $response->assertSee('Sepatu Kulit');
        $response->assertDontSee('Buku Pemrograman');

        // 2. Test Filter berdasarkan kategori
        $response = $this->get(route('seller.produk.index', ['kategori' => 'Buku']));
        $response->assertStatus(200);
        $response->assertSee('Buku Pemrograman');
        $response->assertDontSee('Sepatu Olahraga');
        $response->assertDontSee('Sepatu Kulit');

        // 3. Test Filter berdasarkan harga
        $response = $this->get(route('seller.produk.index', ['min_harga' => 100000, 'max_harga' => 200000]));
        $response->assertStatus(200);
        $response->assertSee('Sepatu Olahraga');
        $response->assertDontSee('Buku Pemrograman');
        $response->assertDontSee('Sepatu Kulit');

        // 4. Test Kombinasi
        $response = $this->get(route('seller.produk.index', [
            'search' => 'sepatu',
            'kategori' => 'Pakaian',
            'min_harga' => 200000
        ]));
        $response->assertStatus(200);
        $response->assertSee('Sepatu Kulit');
        $response->assertDontSee('Sepatu Olahraga');
        $response->assertDontSee('Buku Pemrograman');
    }
}
