<x-app-layout>
    <x-slot name="header">
        Edit Produk: {{ $produk->nama_produk }}
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-2xl mx-auto">
        <div class="p-6 text-gray-900">
            <form action="{{ route('seller.produk.update', $produk->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="toko_id" class="block text-sm font-medium text-gray-700">Toko</label>
                    <select name="toko_id" id="toko_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <option value="">Pilih Toko</option>
                        @foreach($tokos as $toko)
                            <option value="{{ $toko->id }}" {{ old('toko_id', $produk->toko_id) == $toko->id ? 'selected' : '' }}>{{ $toko->nama_toko }}</option>
                        @endforeach
                    </select>
                    @error('toko_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                    @error('nama_produk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $produk->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="harga_pokok" class="block text-sm font-medium text-gray-700">Harga Pokok (HPP) Rp</label>
                        <input type="number" name="harga_pokok" id="harga_pokok" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('harga_pokok', $produk->harga_pokok) }}" min="0" required>
                        @error('harga_pokok')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga Jual (Rp)</label>
                        <input type="number" name="harga" id="harga" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('harga', $produk->harga) }}" min="0" required>
                        @error('harga')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stok" id="stok" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('stok', $produk->stok) }}" min="0" required>
                        @error('stok')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="berat" class="block text-sm font-medium text-gray-700">Berat (gram)</label>
                        <input type="number" name="berat" id="berat" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('berat', $produk->berat) }}" min="1" required>
                        @error('berat')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <option value="aktif" {{ old('status', $produk->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $produk->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('seller.produk.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Batal</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Perbarui</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
