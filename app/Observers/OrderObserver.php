<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        $originalStatus = $order->getOriginal('status');
        $newStatus = $order->status;

        // Jika berubah dari menunggu_pembayaran ke dibayar/diproses, kurangi stok
        if ($originalStatus === 'menunggu_pembayaran' && in_array($newStatus, ['dibayar', 'diproses', 'dikirim', 'selesai'])) {
            foreach ($order->items as $item) {
                if ($item->produk) {
                    $item->produk->decrement('stok', $item->qty);
                }
            }
        }

        // Jika dibatalkan dan sebelumnya sudah memotong stok (bukan dari menunggu_pembayaran)
        if ($newStatus === 'dibatalkan' && in_array($originalStatus, ['dibayar', 'diproses', 'dikirim', 'selesai'])) {
            foreach ($order->items as $item) {
                if ($item->produk) {
                    $item->produk->increment('stok', $item->qty);
                }
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
