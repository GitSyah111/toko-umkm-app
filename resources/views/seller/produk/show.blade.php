<x-app-layout>
    <x-slot name="header">
        Detail Produk
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-4xl mx-auto">
        <div class="p-6 text-gray-900">
            <div class="mb-6 flex justify-between items-start">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">{{ $produk->nama_produk }}</h3>
                    <p class="text-sm text-gray-500 mt-1">Toko: {{ optional($produk->toko)->nama_toko }}</p>
                </div>
                <div>
                    @if($produk->status === 'aktif')
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                    @else
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                    @endif
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium text-gray-900">Nama Produk</dt>
                        <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">{{ $produk->nama_produk }}</dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium text-gray-900">Harga</dt>
                        <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">Rp {{ number_format($produk->harga, 0, ',', '.') }}</dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium text-gray-900">Stok Tersedia</dt>
                        <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">{{ $produk->stok }}</dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium text-gray-900">Deskripsi Produk</dt>
                        <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0 whitespace-pre-line">{{ $produk->deskripsi ?? '-' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Ulasan Produk -->
            <div class="mt-8 border-t border-gray-200 pt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Ulasan Produk</h3>
                @if($produk->reviews && $produk->reviews->where('status', 'approved')->count() > 0)
                    <div class="space-y-4">
                        @foreach($produk->reviews->where('status', 'approved') as $review)
                            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="font-semibold text-gray-800">{{ $review->user->name ?? 'Pembeli' }}</div>
                                    <div class="text-yellow-500 font-bold">
                                        {{ $review->rating }} / 5
                                    </div>
                                </div>
                                <p class="text-gray-700 text-sm whitespace-pre-line">{{ $review->komentar ?: 'Tidak ada komentar.' }}</p>
                                <div class="text-xs text-gray-500 mt-2">{{ $review->created_at->format('d M Y') }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">Belum ada ulasan untuk produk ini.</p>
                @endif
            </div>

            <div class="flex justify-end gap-2 mt-6 border-t border-gray-200 pt-4">
                <a href="{{ route('seller.produk.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Kembali</a>
                <a href="{{ route('seller.produk.edit', $produk->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
            </div>
        </div>
    </div>
</x-app-layout>
