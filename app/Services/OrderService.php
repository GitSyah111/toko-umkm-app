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
                    if ($item->qty > $item->produk->stok) {
                        throw new \Exception("Stok produk '{$item->produk->nama_produk}' tidak mencukupi (Sisa: {$item->produk->stok}).");
                    }
                    $totalHarga += $item->produk->harga * $item->qty;
                }
                
                $ongkir = 15000; // Simplified ongkir calculation

                $order = Order::create([
                    'order_number' => 'INV-' . now()->format('Ymd') . '-' . mt_rand(1000, 9999),
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
                        'qty' => $item->qty,
                        'harga_satuan' => $item->produk->harga,
                        'hpp_satuan' => $item->produk->harga_pokok,
                        'subtotal' => $item->produk->harga * $item->qty,
                    ]);
                }
            }

            // Clear cart
            $cart->items()->delete();
        });
    }

    /**
     * Update order status by buyer.
     *
     * @param Order $order
     * @param string $action
     * @param string|null $alasan
     * @return void
     */
    public function updateOrderStatus(Order $order, string $action, ?string $alasan = null)
    {
        if ($action === 'cancel') {
            $order->update(['status' => 'dibatalkan', 'alasan_pembatalan' => $alasan]);
        } elseif ($action === 'complete') {
            $order->update(['status' => 'selesai']);
        }
    }
}
