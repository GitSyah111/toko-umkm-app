<x-app-layout>
    <x-slot name="header">
        Pesanan Masuk
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-lg font-medium">Daftar Pesanan</h2>
                <a href="{{ route('seller.orders.export-cancelled') }}" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">Export Pesanan Dibatalkan (Excel)</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembeli</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Toko</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->tanggal_order ? $order->tanggal_order->format('d M Y H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ optional($order->user)->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ optional($order->toko)->nama_toko }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
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
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('seller.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900">Proses / Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada pesanan masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
