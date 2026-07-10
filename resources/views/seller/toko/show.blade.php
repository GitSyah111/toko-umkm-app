<x-app-layout>
    <x-slot name="header">
        Detail Toko
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-4xl mx-auto">
        <div class="p-6 text-gray-900">
            <div class="mb-6">
                <h3 class="text-xl font-bold text-gray-900">{{ $toko->nama_toko }}</h3>
                <p class="text-sm text-gray-500 mt-1">Dibuat pada {{ $toko->created_at->format('d M Y') }}</p>
            </div>
            
            <div class="border-t border-gray-200 pt-4">
                <dl class="divide-y divide-gray-100">
                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium text-gray-900">Nama Toko</dt>
                        <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">{{ $toko->nama_toko }}</dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium text-gray-900">Deskripsi</dt>
                        <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0 whitespace-pre-line">{{ $toko->deskripsi ?? '-' }}</dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium text-gray-900">Alamat Lengkap</dt>
                        <dd class="mt-1 text-sm text-gray-700 sm:col-span-2 sm:mt-0">{{ $toko->alamat }}</dd>
                    </div>
                </dl>
            </div>

            <div class="flex justify-end gap-2 mt-6 border-t border-gray-200 pt-4">
                <a href="{{ route('seller.toko.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">Kembali</a>
                <a href="{{ route('seller.toko.edit', $toko->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
            </div>
        </div>
    </div>
</x-app-layout>
