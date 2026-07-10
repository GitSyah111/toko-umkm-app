<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Http\Requests\StoreTokoRequest;
use App\Http\Requests\UpdateTokoRequest;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tokos = Toko::where('user_id', auth()->id())->paginate(10);
        return view('seller.toko.index', compact('tokos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seller.toko.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTokoRequest $request)
    {
        $validated = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();
        Toko::create($validated);

        return redirect()->route('seller.toko.index')->with('success', 'Toko berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Toko $toko)
    {
        if ($toko->user_id !== auth()->id()) abort(403);
        return view('seller.toko.show', compact('toko'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Toko $toko)
    {
        if ($toko->user_id !== auth()->id()) abort(403);
        return view('seller.toko.edit', compact('toko'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTokoRequest $request, Toko $toko)
    {
        if ($toko->user_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'required|string',
        ]);

        $toko->update($validated);

        return redirect()->route('seller.toko.index')->with('success', 'Toko berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toko $toko)
    {
        if ($toko->user_id !== auth()->id()) abort(403);
        $toko->delete();
        
        return redirect()->route('seller.toko.index')->with('success', 'Toko berhasil dihapus.');
    }
}
