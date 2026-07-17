<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko UMKM - Jual Beli Online Mudah & Terpercaya</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">

    <!-- Header -->
    <header class="bg-white border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-toko-green">
                        TokoKita
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 max-w-2xl mx-8">
                    <div class="relative">
                        <input type="text" class="w-full bg-gray-100 border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:border-toko-green focus:ring-toko-green text-sm" placeholder="Cari di TokoKita...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Right Navigation -->
                <div class="flex items-center space-x-6">
                    <!-- Cart -->
                    <a href="#" class="text-gray-500 hover:text-gray-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </a>

                    <div class="border-l h-6 border-gray-300"></div>

                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-toko-green">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-toko-green border border-toko-green rounded-lg px-4 py-1.5 hover:bg-green-50 transition">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-toko-green rounded-lg px-4 py-1.5 hover:bg-green-600 transition">Daftar</a>
                        @endif
                    @endauth
                </div>
            </div>
            
            <!-- Category Menu (Bottom Header) -->
            <div class="flex space-x-6 py-2 text-sm text-gray-600 overflow-x-auto">
                @foreach($categories ?? [] as $category)
                    <a href="#" class="whitespace-nowrap hover:text-toko-green">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Hero Banner -->
        <div class="mb-8 rounded-xl overflow-hidden bg-gradient-to-r from-toko-green to-green-400 h-64 flex items-center justify-between px-12 relative shadow-lg">
            <div class="text-white z-10">
                <h1 class="text-4xl font-bold mb-4">Belanja Lebih Cepat & Mudah</h1>
                <p class="text-lg mb-6">Temukan berbagai produk UMKM pilihan dengan harga terbaik.</p>
                <a href="#" class="bg-white text-toko-green font-semibold py-2 px-6 rounded-full shadow hover:bg-gray-50 transition">Mulai Belanja</a>
            </div>
            <div class="absolute right-0 top-0 h-full w-1/2 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
        </div>

        <!-- Categories Section -->
        <section class="mb-10 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h2 class="text-xl font-bold mb-4">Kategori Pilihan</h2>
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-4">
                @foreach($categories ?? [] as $category)
                    <a href="#" class="flex flex-col items-center p-3 border rounded-lg hover:border-toko-green hover:shadow-sm transition">
                        <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-toko-green mb-2">
                            @if($category->slug == 'elektronik')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            @elseif($category->slug == 'fashion')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            @elseif($category->slug == 'kuliner')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z"></path></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            @endif
                        </div>
                        <span class="text-xs text-center font-medium">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        <!-- Product Grid -->
        <section>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">Rekomendasi Untukmu</h2>
                <a href="#" class="text-toko-green font-medium text-sm hover:underline">Lihat Semua</a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach($produks ?? [] as $produk)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-200 group flex flex-col">
                        <div class="relative pt-[100%] overflow-hidden bg-gray-100">
                            <img src="{{ $produk->gambar }}" alt="{{ $produk->nama_produk }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-300" loading="lazy">
                        </div>
                        <div class="p-3 flex flex-col flex-grow">
                            <h3 class="text-sm text-gray-800 line-clamp-2 mb-1" title="{{ $produk->nama_produk }}">{{ $produk->nama_produk }}</h3>
                            <div class="font-bold text-gray-900 mb-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                            <div class="mt-auto flex items-center text-xs text-gray-500 space-x-1">
                                <svg class="w-3.5 h-3.5 text-toko-green shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path></svg>
                                <span class="truncate">{{ $produk->toko->nama_toko ?? 'Toko UMKM' }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="font-bold text-lg text-toko-green mb-4">TokoKita</h3>
                    <p class="text-sm text-gray-600">Platform jual beli online yang menghubungkan UMKM dengan jutaan pembeli di seluruh Indonesia.</p>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 mb-4">Tentang Kami</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-toko-green">Tentang TokoKita</a></li>
                        <li><a href="#" class="hover:text-toko-green">Hak Kekayaan Intelektual</a></li>
                        <li><a href="#" class="hover:text-toko-green">Karir</a></li>
                        <li><a href="#" class="hover:text-toko-green">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 mb-4">Beli</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-toko-green">Tagihan & Top Up</a></li>
                        <li><a href="#" class="hover:text-toko-green">Tukar Tambah HP</a></li>
                        <li><a href="#" class="hover:text-toko-green">TokoKita COD</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 mb-4">Bantuan dan Panduan</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="#" class="hover:text-toko-green">TokoKita Care</a></li>
                        <li><a href="#" class="hover:text-toko-green">Syarat dan Ketentuan</a></li>
                        <li><a href="#" class="hover:text-toko-green">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t mt-8 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} TokoKita - Toko UMKM App. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
