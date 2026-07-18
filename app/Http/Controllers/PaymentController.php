<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Show payments for the buyer
        $payments = \App\Models\Payment::whereHas('order', function($q) {
            $q->where('user_id', auth()->id());
        })->with('order.toko')->latest()->paginate(10);

        return view('buyer.payments.index', compact('payments'));
    }

    public function create(Request $request)
    {
        $order_id = $request->query('order_id');
        if (!$order_id) {
            return redirect()->route('buyer.orders.index')->with('error', 'Pilih pesanan yang akan dibayar.');
        }

        $order = \App\Models\Order::where('user_id', auth()->id())
            ->where('id', $order_id)
            ->where('status', 'menunggu_pembayaran')
            ->firstOrFail();

        return view('buyer.payments.create', compact('order'));
    }

    public function store(StorePaymentRequest $request, \App\Services\PaymentService $paymentService)
    {

        $paymentService->processPayment(
            auth()->id(),
            $request->order_id,
            $request->metode_pembayaran,
            $request->file('bukti_pembayaran')
        );

        return redirect()->route('buyer.payments.index')->with('success', 'Pembayaran berhasil disubmit. Menunggu verifikasi.');
    }

    public function show(\App\Models\Payment $payment)
    {
        if ($payment->order->user_id !== auth()->id()) abort(403);
        
        return view('buyer.payments.show', compact('payment'));
    }

    // other methods not strictly needed for buyer
    public function edit(\App\Models\Payment $payment) {}
    public function update(Request $request, \App\Models\Payment $payment) {}
    public function destroy(\App\Models\Payment $payment) {}
}
