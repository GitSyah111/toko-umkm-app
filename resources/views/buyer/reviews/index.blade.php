<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ulasan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="border-b py-4 px-6 bg-gray-50 font-bold uppercase text-sm text-gray-600">Produk</th>
                                    <th class="border-b py-4 px-6 bg-gray-50 font-bold uppercase text-sm text-gray-600">Pesanan</th>
                                    <th class="border-b py-4 px-6 bg-gray-50 font-bold uppercase text-sm text-gray-600">Rating</th>
                                    <th class="border-b py-4 px-6 bg-gray-50 font-bold uppercase text-sm text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($reviews as $review)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-4 px-6 border-b text-gray-700">{{ $review->produk->nama_produk ?? '-' }}</td>
                                        <td class="py-4 px-6 border-b text-gray-700">#{{ $review->order_id }}</td>
                                        <td class="py-4 px-6 border-b text-gray-700">{{ $review->rating }} / 5</td>
                                        <td class="py-4 px-6 border-b text-gray-700">
                                            <a href="{{ route('buyer.reviews.show', $review->id) }}" class="text-blue-500 hover:text-blue-700 mr-3">Detail</a>
                                            <a href="{{ route('buyer.reviews.edit', $review->id) }}" class="text-indigo-500 hover:text-indigo-700 mr-3">Edit</a>
                                            <form action="{{ route('buyer.reviews.destroy', $review->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus ulasan ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-4 px-6 border-b text-center text-gray-500">Belum ada ulasan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $reviews->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
