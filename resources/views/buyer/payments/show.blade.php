<x-app-layout>
    <x-slot name="header">
        Detail Pembayaran #PAY-{{ $payment->id }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-3xl mx-auto">
        <div class="p-6 text-gray-900">
            <div class="mb-6 flex justify-between items-start border-b pb-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Pesanan <a href="{{ route('buyer.orders.show', $payment->order_id) }}" class="text-indigo-600 hover:underline">#{{ $payment->order_id }}</a></h3>
                    <p class="text-sm text-gray-500 mt-1">Dikirim ke Toko: {{ optional(optional($payment->order)->toko)->nama_toko }}</p>
                </div>
                <div>
                    @if($payment->status === 'pending')
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Konfirmasi</span>
                    @elseif($payment->status === 'success' || $payment->status === 'sukses')
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">Berhasil</span>
                    @else
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800">Gagal / Ditolak</span>
                    @endif
                </div>
            </div>
            
            <dl class="divide-y divide-gray-100">
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium text-gray-500">Waktu Pembayaran</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ $payment->tanggal_bayar ? \Carbon\Carbon::parse($payment->tanggal_bayar)->format('d M Y H:i:s') : '-' }}</dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium text-gray-500">Jumlah Dibayar</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 font-medium">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                    <dt class="text-sm font-medium text-gray-500">Metode</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 uppercase">{{ str_replace('_', ' ', $payment->metode_pembayaran) }}</dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0 border-b">
                    <dt class="text-sm font-medium text-gray-500">Bukti Transfer</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        @if($payment->bukti_pembayaran)
                            <a href="{{ asset('storage/' . $payment->bukti_pembayaran) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Lihat Gambar
                            </a>
                            <div class="mt-2 max-w-sm rounded border p-1 bg-gray-50">
                                <img src="{{ asset('storage/' . $payment->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="max-w-full h-auto">
                            </div>
                        @else
                            <span class="text-gray-400 italic">Tidak ada lampiran</span>
                        @endif
                    </dd>
                </div>
            </dl>

            <div class="flex justify-end mt-6">
                <a href="{{ route('buyer.payments.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Kembali ke Riwayat</a>
            </div>
        </div>
    </div>
</x-app-layout>
