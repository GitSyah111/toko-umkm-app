<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Http\Requests\StoreProdukRequest;
use App\Http\Requests\UpdateProdukRequest;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Only show products from shops owned by the logged-in seller
        $produks = Produk::whereHas('toko', function ($query) {
            $query->where('user_id', auth()->id());
        })->with('toko')->paginate(10);

        return view('seller.produk.index', compact('produks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tokos = \App\Models\Toko::where('user_id', auth()->id())->get();
        if ($tokos->isEmpty()) {
            return redirect()->route('seller.toko.index')->with('error', 'Anda harus membuat toko terlebih dahulu sebelum menambahkan produk.');
        }
        return view('seller.produk.create', compact('tokos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdukRequest $request)
    {
        $validated = $request->validate([
            'toko_id' => 'required|exists:tokos,id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Ensure the selected toko belongs to the user
        $toko = \App\Models\Toko::where('id', $validated['toko_id'])->where('user_id', auth()->id())->firstOrFail();

        Produk::create($validated);

        return redirect()->route('seller.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        if ($produk->toko->user_id !== auth()->id()) abort(403);
        return view('seller.produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        if ($produk->toko->user_id !== auth()->id()) abort(403);
        $tokos = \App\Models\Toko::where('user_id', auth()->id())->get();
        
        return view('seller.produk.edit', compact('produk', 'tokos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdukRequest $request, Produk $produk)
    {
        if ($produk->toko->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'toko_id' => 'required|exists:tokos,id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        
        // Ensure the selected toko belongs to the user
        $toko = \App\Models\Toko::where('id', $validated['toko_id'])->where('user_id', auth()->id())->firstOrFail();

        $produk->update($validated);

        return redirect()->route('seller.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        if ($produk->toko->user_id !== auth()->id()) abort(403);
        
        $produk->delete();

        return redirect()->route('seller.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
