<x-app-layout>
    <x-slot name="header">
        Manajemen Produk
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-medium">Daftar Produk</h2>
                <a href="{{ route('seller.produk.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Produk
                </a>
            </div>

            <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                <form action="{{ route('seller.produk.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <x-input-label for="search" value="Cari Produk" />
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" value="{{ request('search') }}" placeholder="Nama produk..." />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="kategori" value="Kategori" />
                        <x-text-input id="kategori" name="kategori" type="text" class="mt-1 block w-full" value="{{ request('kategori') }}" placeholder="Kategori..." />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="min_harga" value="Harga Min" />
                        <x-text-input id="min_harga" name="min_harga" type="number" class="mt-1 block w-full" value="{{ request('min_harga') }}" placeholder="0" />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="max_harga" value="Harga Max" />
                        <x-text-input id="max_harga" name="max_harga" type="number" class="mt-1 block w-full" value="{{ request('max_harga') }}" placeholder="1000000" />
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded w-full md:w-auto">
                            Filter
                        </button>
                        <a href="{{ route('seller.produk.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded text-center w-full md:w-auto">
                            Reset
                        </a>
                    </div>
                </form>
            </div>


            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Toko</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($produks as $produk)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ optional($produk->toko)->nama_toko }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $produk->nama_produk }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $produk->stok }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($produk->status === 'aktif')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('seller.produk.show', $produk->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Lihat</a>
                                    <a href="{{ route('seller.produk.edit', $produk->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                    <form action="{{ route('seller.produk.destroy', $produk->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $produks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
