<x-app-layout>
    <x-slot name="header">
        Wishlist Saya
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h2 class="text-lg font-medium mb-6">Produk Tersimpan</h2>

            @if($wishlists->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Wishlist Anda kosong</h3>
                    <p class="mt-1 text-sm text-gray-500">Simpan produk impian Anda agar tidak lupa.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($wishlists as $wishlist)
                        @if($wishlist->produk)
                            <div class="bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                                <!-- Placeholder for Image -->
                                <div class="h-48 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No Image</span>
                                </div>
                                
                                <div class="p-4">
                                    <div class="text-xs text-gray-500 mb-1">{{ optional($wishlist->produk->toko)->nama_toko }}</div>
                                    <h3 class="text-sm font-bold text-gray-900 truncate" title="{{ $wishlist->produk->nama_produk }}">
                                        {{ $wishlist->produk->nama_produk }}
                                    </h3>
                                    <div class="mt-2 text-indigo-600 font-bold">
                                        Rp {{ number_format($wishlist->produk->harga, 0, ',', '.') }}
                                    </div>
                                    
                                    <div class="mt-4 flex flex-col gap-2">
                                        <!-- Add to Cart Form -->
                                        <form action="{{ route('buyer.cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="produk_id" value="{{ $wishlist->produk->id }}">
                                            <input type="hidden" name="kuantitas" value="1">
                                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition-colors">
                                                + Keranjang
                                            </button>
                                        </form>
                                        
                                        <!-- Remove from Wishlist Form -->
                                        <form action="{{ route('buyer.wishlist.destroy', $wishlist->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-bold py-2 px-4 rounded text-sm transition-colors" onsubmit="return confirm('Hapus dari wishlist?');">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                
                <div class="mt-6">
                    {{ $wishlists->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
