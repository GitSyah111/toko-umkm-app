<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = \App\Models\Cart::firstOrCreate(['user_id' => auth()->id()]);
        $cartItems = $cart->items()->with('produk.toko')->get();
        return view('buyer.cart.index', compact('cart', 'cartItems'));
    }

    public function store(\Illuminate\Http\Request $request, \App\Services\CartService $cartService)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'kuantitas' => 'required|integer|min:1',
        ]);

        $cartService->addToCart(
            auth()->id(),
            $request->produk_id,
            $request->kuantitas
        );

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang.');
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'kuantitas' => 'required|integer|min:1',
        ]);

        $cartItem = \App\Models\CartItem::whereHas('cart', function($q) {
            $q->where('user_id', auth()->id());
        })->findOrFail($id);

        $cartItem->update(['kuantitas' => $request->kuantitas]);

        return redirect()->back()->with('success', 'Kuantitas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $cartItem = \App\Models\CartItem::whereHas('cart', function($q) {
            $q->where('user_id', auth()->id());
        })->findOrFail($id);

        $cartItem->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
