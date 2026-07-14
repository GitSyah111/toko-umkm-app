<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\UploadedFile;

class PaymentService
{
    /**
     * Process a payment submission.
     *
     * @param int $userId
     * @param int $orderId
     * @param string $metodePembayaran
     * @param UploadedFile $buktiPembayaran
     * @return Payment
     */
    public function processPayment(int $userId, int $orderId, string $metodePembayaran, UploadedFile $buktiPembayaran): Payment
    {
        $order = Order::where('user_id', $userId)
            ->where('id', $orderId)
            ->where('status', 'menunggu_pembayaran')
            ->firstOrFail();

        $path = $buktiPembayaran->store('payments', 'public');

        $payment = Payment::create([
            'order_id' => $order->id,
            'tanggal_bayar' => now(),
            'jumlah_bayar' => $order->total_bayar,
            'metode_pembayaran' => $metodePembayaran,
            'bukti_pembayaran' => $path,
            'status' => 'pending', 
        ]);

        $order->update(['status' => 'dibayar']);

        return $payment;
    }
}
