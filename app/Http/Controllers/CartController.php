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

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'kuantitas' => 'required|integer|min:1',
        ]);

        $cart = \App\Models\Cart::firstOrCreate(['user_id' => auth()->id()]);
        
        $cartItem = $cart->items()->where('product_id', $request->produk_id)->first();
        if ($cartItem) {
            $cartItem->increment('kuantitas', $request->kuantitas);
        } else {
            $cart->items()->create([
                'product_id' => $request->produk_id,
                'kuantitas' => $request->kuantitas,
            ]);
        }

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
