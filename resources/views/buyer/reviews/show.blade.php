<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Ulasan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-semibold mb-4">Ulasan untuk: {{ $review->produk->nama_produk ?? '-' }}</h3>

                    <div class="mb-4">
                        <strong>Pesanan:</strong> <a href="{{ route('buyer.orders.show', $review->order_id) }}" class="text-blue-500 hover:underline">#{{ $review->order_id }}</a>
                    </div>

                    <div class="mb-4">
                        <strong>Rating:</strong> <span class="text-yellow-500 font-bold">{{ $review->rating }} / 5</span>
                    </div>

                    <div class="mb-4">
                        <strong>Komentar:</strong>
                        <p class="mt-2 text-gray-700 whitespace-pre-line">{{ $review->komentar ?: 'Tidak ada komentar.' }}</p>
                    </div>

                    <div class="mb-4 text-sm text-gray-500">
                        Ditulis pada: {{ $review->created_at->format('d M Y H:i') }}
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <a href="{{ route('buyer.reviews.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                            Kembali
                        </a>
                        <a href="{{ route('buyer.reviews.edit', $review->id) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            Edit Ulasan
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
