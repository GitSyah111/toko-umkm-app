<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Process checkout from cart.
     *
     * @param int $userId
     * @param string $alamatPengiriman
     * @return void
     * @throws \Exception
     */
    public function checkoutFromCart(int $userId, string $alamatPengiriman)
    {
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart || $cart->items->isEmpty()) {
            throw new \Exception('Keranjang kosong.');
        }

        $cartItems = $cart->items()->with('produk')->get();
        
        $groupedItems = $cartItems->groupBy(function($item) {
            return $item->produk->toko_id;
        });

        DB::transaction(function() use ($groupedItems, $userId, $alamatPengiriman, $cart) {
            foreach ($groupedItems as $tokoId => $items) {
                $totalHarga = 0;
                foreach ($items as $item) {
                    $totalHarga += $item->produk->harga * $item->kuantitas;
                }
                
                $ongkir = 15000; // Simplified ongkir calculation

                $order = Order::create([
                    'user_id' => $userId,
                    'toko_id' => $tokoId,
                    'tanggal_order' => now(),
                    'status' => 'menunggu_pembayaran',
                    'total_harga' => $totalHarga,
                    'ongkir' => $ongkir,
                    'total_bayar' => $totalHarga + $ongkir,
                    'alamat_pengiriman' => $alamatPengiriman,
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'kuantitas' => $item->kuantitas,
                        'harga_satuan' => $item->produk->harga,
                        'subtotal' => $item->produk->harga * $item->kuantitas,
                    ]);
                }
            }

            // Clear cart
            $cart->items()->delete();
        });
    }
}
