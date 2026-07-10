<x-app-layout>
    <x-slot name="header">
        Checkout Pesanan
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-4xl mx-auto">
        <div class="p-6 text-gray-900">
            <h2 class="text-xl font-bold mb-4 border-b pb-2">Rincian Pembelian</h2>
            
            <div class="mb-6">
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900">
                                {{ optional($item->produk)->nama_produk }}
                                <div class="text-xs text-gray-500">{{ optional(optional($item->produk)->toko)->nama_toko }}</div>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900 text-right">
                                Rp {{ number_format(optional($item->produk)->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900 text-center">
                                {{ $item->kuantitas }}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900 text-right font-medium">
                                Rp {{ number_format(optional($item->produk)->harga * $item->kuantitas, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 font-bold">
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-right text-sm">Total Belanja:</td>
                            <td class="px-4 py-2 text-right text-indigo-600">Rp {{ number_format($totalHarga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-4 py-2 text-right text-sm text-gray-500 font-normal">Estimasi Ongkos Kirim (Per Toko):</td>
                            <td class="px-4 py-2 text-right text-gray-500 font-normal">Rp 15.000</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <form action="{{ route('buyer.orders.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <h2 class="text-xl font-bold mb-4 border-b pb-2">Alamat Pengiriman</h2>
                    <textarea name="alamat_pengiriman" id="alamat_pengiriman" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Tuliskan alamat lengkap pengiriman Anda" required>{{ old('alamat_pengiriman') }}</textarea>
                    @error('alamat_pengiriman')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4 mt-6 border-t pt-4">
                    <a href="{{ route('buyer.cart.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg">Kembali ke Keranjang</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md">Buat Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
