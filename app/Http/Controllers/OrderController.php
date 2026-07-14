<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = \App\Models\Order::where('user_id', auth()->id())->with(['toko', 'payment'])->latest()->paginate(10);
        return view('buyer.orders.index', compact('orders'));
    }

    public function create()
    {
        $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('buyer.cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $cartItems = $cart->items()->with('produk.toko')->get();
        // Calculate totals, optionally group by Toko if needed. For simplicity, just sum all up.
        $totalHarga = 0;
        foreach ($cartItems as $item) {
            $totalHarga += optional($item->produk)->harga * $item->kuantitas;
        }

        return view('buyer.orders.create', compact('cartItems', 'totalHarga'));
    }

    public function store(\Illuminate\Http\Request $request, \App\Services\OrderService $orderService)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string',
        ]);

        try {
            $orderService->checkoutFromCart(
                auth()->id(),
                $request->alamat_pengiriman
            );
        } catch (\Exception $e) {
            return redirect()->route('buyer.cart.index')->with('error', $e->getMessage());
        }

        return redirect()->route('buyer.orders.index')->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    public function show(\App\Models\Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load(['items.produk', 'toko', 'payment']);
        return view('buyer.orders.show', compact('order'));
    }

    public function edit(\App\Models\Order $order)
    {
        // Not used by buyer typically
    }

    public function update(Request $request, \App\Models\Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        
        // Buyer can cancel order or confirm delivery
        if ($request->has('cancel')) {
            $order->update(['status' => 'dibatalkan', 'alasan_pembatalan' => $request->alasan_pembatalan]);
            return redirect()->back()->with('success', 'Pesanan dibatalkan.');
        } elseif ($request->has('complete')) {
            $order->update(['status' => 'selesai']);
            return redirect()->back()->with('success', 'Pesanan diselesaikan.');
        }

        return redirect()->back();
    }

    public function destroy(\App\Models\Order $order)
    {
        // Not used typically, use cancel instead
    }
    public function printInvoice(\App\Models\Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        $order->load(['items.produk', 'toko', 'payment', 'user']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('order'));
        return $pdf->stream('invoice-'.$order->id.'.pdf');
    }
}
