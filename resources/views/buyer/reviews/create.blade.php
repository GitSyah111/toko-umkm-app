<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beri Ulasan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-semibold mb-4">Ulas Produk: {{ $produk->nama_produk }}</h3>

                    <form action="{{ route('buyer.reviews.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="product_id" value="{{ $produk->id }}">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <div class="mb-4">
                            <label for="rating" class="block text-sm font-medium text-gray-700">Rating (1-5)</label>
                            <select id="rating" name="rating" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>5 - Sangat Bagus</option>
                                <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>4 - Bagus</option>
                                <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>3 - Cukup</option>
                                <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>2 - Kurang</option>
                                <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>1 - Sangat Kurang</option>
                            </select>
                            @error('rating')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="komentar" class="block text-sm font-medium text-gray-700">Komentar (Opsional)</label>
                            <textarea id="komentar" name="komentar" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('komentar') }}</textarea>
                            @error('komentar')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('buyer.orders.show', $order->id) }}" class="text-gray-500 hover:text-gray-700 mr-4">Batal</a>
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Ulasan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
