<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Review;
use App\Models\Order;
use App\Models\Produk;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::where('user_id', Auth::id())->with(['produk', 'order'])->paginate(10);
        return view('buyer.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $order_id = $request->query('order_id');
        $product_id = $request->query('product_id');

        if (!$order_id || !$product_id) {
            return redirect()->route('buyer.orders.index')->with('error', 'Pesanan atau produk tidak valid.');
        }

        $order = Order::where('id', $order_id)->where('user_id', Auth::id())->firstOrFail();
        
        // Ensure order is delivered before reviewing
        if ($order->status !== 'selesai') {
            return redirect()->route('buyer.orders.show', $order->id)->with('error', 'Hanya pesanan yang sudah selesai yang dapat diulas.');
        }

        $produk = Produk::findOrFail($product_id);

        // Check if already reviewed
        $existingReview = Review::where('user_id', Auth::id())
            ->where('order_id', $order->id)
            ->where('product_id', $produk->id)
            ->first();

        if ($existingReview) {
            return redirect()->route('buyer.reviews.show', $existingReview->id)->with('info', 'Anda sudah memberikan ulasan untuk produk ini pada pesanan tersebut.');
        }

        return view('buyer.reviews.create', compact('order', 'produk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        // Extra check for order status
        $order = Order::where('id', $validated['order_id'])->where('user_id', Auth::id())->firstOrFail();
        if ($order->status !== 'selesai') {
            return redirect()->route('buyer.orders.show', $order->id)->with('error', 'Hanya pesanan yang sudah selesai yang dapat diulas.');
        }

        Review::create($validated);

        return redirect()->route('buyer.reviews.index')->with('success', 'Ulasan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::id())->with(['produk', 'order'])->firstOrFail();
        return view('buyer.reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::id())->with(['produk', 'order'])->firstOrFail();
        return view('buyer.reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, string $id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $review->update($request->validated());

        return redirect()->route('buyer.reviews.index')->with('success', 'Ulasan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $review->delete();

        return redirect()->route('buyer.reviews.index')->with('success', 'Ulasan berhasil dihapus.');
    }
}
