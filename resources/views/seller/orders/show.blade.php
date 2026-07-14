<x-app-layout>
    <x-slot name="header">
        Detail Pesanan #{{ $order->id }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-5xl mx-auto">
        <div class="p-6 text-gray-900">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informasi Pesanan -->
                <div>
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Pesanan</h3>
                    <dl class="divide-y divide-gray-100">
                        <div class="py-2 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Order</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $order->tanggal_order ? $order->tanggal_order->format('d M Y H:i') : '-' }}</dd>
                        </div>
                        <div class="py-2 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="text-sm text-gray-900 col-span-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($order->status == 'menunggu_pembayaran') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'dibayar') bg-blue-100 text-blue-800
                                    @elseif($order->status == 'diproses') bg-indigo-100 text-indigo-800
                                    @elseif($order->status == 'dikirim') bg-purple-100 text-purple-800
                                    @elseif($order->status == 'selesai') bg-green-100 text-green-800
                                    @elseif($order->status == 'dibatalkan') bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ str_replace('_', ' ', ucfirst($order->status)) }}
                                </span>
                            </dd>
                        </div>
                        <div class="py-2 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Pembeli</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ optional($order->user)->name }}</dd>
                        </div>
                        <div class="py-2 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Alamat Pengiriman</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $order->alamat_pengiriman }}</dd>
                        </div>
                        <div class="py-2 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Resi Pengiriman</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $order->resi_pengiriman ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Update Status Form -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-bold mb-4">Update Pesanan</h3>
                    <form action="{{ route('seller.orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status Pesanan</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="menunggu_pembayaran" {{ $order->status == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                <option value="dibayar" {{ $order->status == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                                <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="dikirim" {{ $order->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $order->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="resi_pengiriman" class="block text-sm font-medium text-gray-700">Resi Pengiriman</label>
                            <input type="text" name="resi_pengiriman" id="resi_pengiriman" value="{{ old('resi_pengiriman', $order->resi_pengiriman) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Masukkan nomor resi jika dikirim">
                        </div>

                        <div class="mb-4">
                            <label for="alasan_pembatalan" class="block text-sm font-medium text-gray-700">Alasan Pembatalan (Opsional)</label>
                            <textarea name="alasan_pembatalan" id="alasan_pembatalan" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('alasan_pembatalan', $order->alasan_pembatalan) }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Detail Item -->
            <div class="mt-8">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Produk yang Dipesan</h3>
                <table class="min-w-full divide-y divide-gray-200 border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Kuantitas</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($order->items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ optional($item->produk)->nama_produk ?? 'Produk Tidak Ditemukan' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                {{ $item->kuantitas }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium text-right">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 font-bold">
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm text-gray-900">Total Harga</td>
                            <td class="px-6 py-4 text-right text-sm text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-sm text-gray-900">Ongkos Kirim</td>
                            <td class="px-6 py-4 text-right text-sm text-gray-900">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-right text-base text-gray-900">Total Bayar</td>
                            <td class="px-6 py-4 text-right text-base text-indigo-700">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('seller.orders.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Kembali ke Daftar</a>
                <div class="flex gap-2">
                    <a href="{{ route('seller.orders.shipping-label', $order->id) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">Cetak Label Pengiriman</a>
                    <a href="{{ route('seller.orders.invoice', $order->id) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">Cetak Invoice</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
