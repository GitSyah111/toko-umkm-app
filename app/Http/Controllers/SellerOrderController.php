<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index()
    {
        $tokos = \App\Models\Toko::where('user_id', auth()->id())->pluck('id');
        $orders = \App\Models\Order::whereIn('toko_id', $tokos)->with(['user', 'toko', 'payment'])->latest()->paginate(10);
        return view('seller.orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        if ($order->toko->user_id !== auth()->id()) abort(403);
        $order->load(['items.produk', 'user', 'payment']);
        return view('seller.orders.show', compact('order'));
    }

    public function update(Request $request, \App\Models\Order $order)
    {
        if ($order->toko->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'status' => 'required|in:menunggu_pembayaran,dibayar,diproses,dikirim,selesai,dibatalkan',
            'resi_pengiriman' => 'nullable|string|max:255',
            'alasan_pembatalan' => 'nullable|string',
        ]);

        $order->update($validated);
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
    public function printInvoice(\App\Models\Order $order)
    {
        if ($order->toko->user_id !== auth()->id()) abort(403);
        $order->load(['items.produk', 'user', 'payment', 'toko']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.invoice', compact('order'));
        return $pdf->stream('invoice-'.$order->id.'.pdf');
    }

    public function printShippingLabel(\App\Models\Order $order)
    {
        if ($order->toko->user_id !== auth()->id()) abort(403);
        $order->load(['items.produk', 'user', 'toko']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.shipping_label', compact('order'));
        return $pdf->stream('shipping-label-'.$order->id.'.pdf');
    }

    public function exportCancelledExcel()
    {
        $toko = auth()->user()->toko;
        if (!$toko) abort(403);
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\CancelledOrdersExport($toko->id), 'cancelled-orders.xlsx');
    }
}
