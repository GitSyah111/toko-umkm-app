<x-app-layout>
    <x-slot name="header">
        Keranjang Belanja
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-5xl mx-auto">
        <div class="p-6 text-gray-900">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if($cartItems->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Keranjang masih kosong</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai belanja produk favoritmu sekarang!</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Kuantitas</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $totalKeranjang = 0; @endphp
                            @foreach($cartItems as $item)
                                @php 
                                    $harga = optional($item->produk)->harga ?? 0;
                                    $subtotal = $harga * $item->kuantitas;
                                    $totalKeranjang += $subtotal;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ optional($item->produk)->nama_produk ?? 'Produk Tidak Ditemukan' }}</div>
                                        <div class="text-sm text-gray-500">{{ optional(optional($item->produk)->toko)->nama_toko }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                        Rp {{ number_format($harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <form action="{{ route('buyer.cart.update', $item->id) }}" method="POST" class="inline-flex items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="kuantitas" value="{{ $item->kuantitas }}" min="1" class="w-16 text-center text-sm rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mr-2">
                                            <button type="submit" class="text-indigo-600 hover:text-indigo-900 text-xs">Update</button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('buyer.cart.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus dari keranjang?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-base font-bold text-gray-900">Total Keranjang</td>
                                <td class="px-6 py-4 text-right text-base font-bold text-indigo-700">Rp {{ number_format($totalKeranjang, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="flex justify-end mt-6">
                    <a href="{{ route('buyer.orders.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md">
                        Lanjut ke Pembayaran (Checkout)
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
