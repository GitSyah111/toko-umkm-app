<x-app-layout>
    <x-slot name="header">
        Detail Pesanan #{{ $order->id }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-5xl mx-auto">
        <div class="p-6 text-gray-900">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Status & Ringkasan -->
                <div>
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Status Pesanan</h3>
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <div class="text-sm text-gray-500 mb-1">Status Saat Ini:</div>
                        <div class="text-lg font-bold
                            @if($order->status == 'menunggu_pembayaran') text-yellow-600
                            @elseif($order->status == 'dibayar') text-blue-600
                            @elseif($order->status == 'diproses') text-indigo-600
                            @elseif($order->status == 'dikirim') text-purple-600
                            @elseif($order->status == 'selesai') text-green-600
                            @elseif($order->status == 'dibatalkan') text-red-600
                            @endif
                        ">
                            {{ str_replace('_', ' ', strtoupper($order->status)) }}
                        </div>
                        
                        @if($order->status == 'dibatalkan' && $order->alasan_pembatalan)
                            <div class="mt-2 text-sm text-red-500 bg-red-50 p-2 rounded">
                                <strong>Alasan:</strong> {{ $order->alasan_pembatalan }}
                            </div>
                        @endif
                        
                        @if($order->resi_pengiriman)
                            <div class="mt-2 text-sm text-gray-800 bg-gray-100 p-2 rounded">
                                <strong>Resi Pengiriman:</strong> <span class="font-mono">{{ $order->resi_pengiriman }}</span>
                            </div>
                        @endif
                    </div>

                    @if($order->status == 'menunggu_pembayaran')
                        <a href="{{ route('buyer.payments.create', ['order_id' => $order->id]) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2">
                            Lakukan Pembayaran Sekarang
                        </a>
                        
                        <form action="{{ route('buyer.orders.update', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="cancel" value="1">
                            <input type="hidden" name="alasan_pembatalan" value="Dibatalkan oleh pembeli">
                            <button type="submit" class="w-full text-center bg-white border border-red-300 text-red-600 hover:bg-red-50 font-bold py-2 px-4 rounded">
                                Batalkan Pesanan
                            </button>
                        </form>
                    @elseif($order->status == 'dikirim')
                        <form action="{{ route('buyer.orders.update', $order->id) }}" method="POST" onsubmit="return confirm('Apakah Anda sudah menerima pesanan ini dengan baik?');">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="complete" value="1">
                            <button type="submit" class="w-full text-center bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded shadow-md">
                                Pesanan Diterima (Selesaikan)
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Informasi Pengiriman -->
                <div>
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Pengiriman</h3>
                    <dl class="divide-y divide-gray-100">
                        <div class="py-2 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Tanggal Order</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ $order->tanggal_order ? $order->tanggal_order->format('d M Y H:i') : '-' }}</dd>
                        </div>
                        <div class="py-2 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Toko Penjual</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ optional($order->toko)->nama_toko }}</dd>
                        </div>
                        <div class="py-2 grid grid-cols-1 gap-1">
                            <dt class="text-sm font-medium text-gray-500">Alamat Tujuan</dt>
                            <dd class="text-sm text-gray-900 bg-gray-50 p-2 rounded mt-1">{{ $order->alamat_pengiriman }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Detail Item -->
            <div>
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Produk yang Dipesan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
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
                                <td colspan="3" class="px-6 py-4 text-right text-base text-gray-900">Total Pembayaran</td>
                                <td class="px-6 py-4 text-right text-base text-indigo-700">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('buyer.orders.index') }}" class="text-indigo-600 hover:text-indigo-900">&larr; Kembali ke Daftar Pesanan</a>
            </div>
        </div>
    </div>
</x-app-layout>
