<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use App\Models\Toko;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_buyer_can_review_delivered_order_and_see_it_on_product_page(): void
    {
        // 1. Setup Data
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

        $produk = Produk::create([
            'toko_id' => $toko->id,
            'nama_produk' => 'Produk Test',
            'harga' => 10000,
            'stok' => 10,
            'status' => 'aktif'
        ]);

        $buyer = User::create([
            'name' => 'Buyer Test',
            'email' => 'buyer@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'pembeli'
        ]);

        $order = Order::create([
            'user_id' => $buyer->id,
            'toko_id' => $toko->id,
            'status' => 'selesai',
            'total_harga' => 10000,
            'ongkir' => 5000,
            'total_bayar' => 15000,
            'alamat_pengiriman' => 'Alamat Test',
            'tanggal_order' => now(),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $produk->id,
            'harga_satuan' => 10000,
            'qty' => 1,
            'subtotal' => 10000,
        ]);

        // 2. Login as buyer
        $this->actingAs($buyer);

        $this->withoutExceptionHandling();

        // Access the review create page
        $response = $this->get("/buyer/reviews/create?order_id={$order->id}&product_id={$produk->id}");
        $response->assertStatus(200);

        // 3. Submit review and rating
        $response = $this->post('/buyer/reviews', [
            'order_id' => $order->id,
            'product_id' => $produk->id,
            'rating' => 5,
            'komentar' => 'Produk sangat memuaskan, pengiriman cepat!',
        ]);
        
        $response->assertRedirect(route('buyer.reviews.index'));
        $this->assertDatabaseHas('reviews', [
            'order_id' => $order->id,
            'product_id' => $produk->id,
            'user_id' => $buyer->id,
            'rating' => 5,
            'komentar' => 'Produk sangat memuaskan, pengiriman cepat!',
        ]);

        // 4. Verify review appears on seller's product detail page (as seller or admin or anyone viewing it)
        $this->actingAs($seller);
        $response = $this->get("/seller/produk/{$produk->id}");
        $response->assertStatus(200);
        $response->assertSee('Produk sangat memuaskan, pengiriman cepat!');
        $response->assertSee('5 / 5');
    }
}
