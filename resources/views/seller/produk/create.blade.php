<x-app-layout>
    <x-slot name="header">
        Tambah Produk Baru
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg max-w-2xl mx-auto" x-data="{
        nama_produk: '{{ old('nama_produk') }}',
        harga: '{{ old('harga') }}',
        stok: '{{ old('stok') }}',
        get isNamaValid() { return this.nama_produk.length === 0 || this.nama_produk.length >= 5; },
        get isHargaValid() { return this.harga === '' || parseFloat(this.harga) >= 0; },
        get isStokValid() { return this.stok === '' || (Number.isInteger(Number(this.stok)) && Number(this.stok) >= 0); },
        get isFormValid() { return this.nama_produk.length >= 5 && parseFloat(this.harga) >= 0 && Number.isInteger(Number(this.stok)) && Number(this.stok) >= 0; }
    }">
        <div class="p-6 text-gray-900">
            <form action="{{ route('seller.produk.store') }}" method="POST" @submit="if(!isFormValid) { $event.preventDefault(); alert('Harap perbaiki error pada form sebelum menyimpan.'); }">
                @csrf
                
                <div class="mb-4">
                    <label for="toko_id" class="block text-sm font-medium text-gray-700">Toko</label>
                    <select name="toko_id" id="toko_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <option value="">Pilih Toko</option>
                        @foreach($tokos as $toko)
                            <option value="{{ $toko->id }}" {{ old('toko_id') == $toko->id ? 'selected' : '' }}>{{ $toko->nama_toko }}</option>
                        @endforeach
                    </select>
                    @error('toko_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" x-model="nama_produk" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                    <p x-show="!isNamaValid" class="text-red-500 text-xs mt-1" style="display: none;">Nama produk minimal 5 karakter.</p>
                    @error('nama_produk')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ old('kategori') }}">
                    @error('kategori')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                        <input type="number" name="harga" id="harga" x-model="harga" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" min="0" required>
                        <p x-show="!isHargaValid" class="text-red-500 text-xs mt-1" style="display: none;">Harga tidak boleh negatif.</p>
                        @error('harga')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="stok" class="block text-sm font-medium text-gray-700">Stok</label>
                        <input type="number" name="stok" id="stok" x-model="stok" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" min="0" step="1" required>
                        <p x-show="!isStokValid" class="text-red-500 text-xs mt-1" style="display: none;">Stok harus angka bulat dan tidak negatif.</p>
                        @error('stok')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('seller.produk.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">Batal</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50 disabled:cursor-not-allowed" x-bind:disabled="!isFormValid">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
