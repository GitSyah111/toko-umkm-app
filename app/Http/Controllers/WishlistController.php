<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Http\Requests\StoreWishlistRequest;
use App\Http\Requests\UpdateWishlistRequest;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlists = \App\Models\Wishlist::where('user_id', auth()->id())->with('produk.toko')->latest()->paginate(10);
        return view('buyer.wishlist.index', compact('wishlists'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
        ]);

        \App\Models\Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $request->produk_id,
        ]);

        return redirect()->back()->with('success', 'Produk ditambahkan ke wishlist.');
    }

    public function destroy($id)
    {
        $wishlist = \App\Models\Wishlist::where('user_id', auth()->id())->findOrFail($id);
        $wishlist->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari wishlist.');
    }

    // other methods
    public function create() {}
    public function show(\App\Models\Wishlist $wishlist) {}
    public function edit(\App\Models\Wishlist $wishlist) {}
    public function update(Request $request, \App\Models\Wishlist $wishlist) {}
}
