<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-white selection:bg-toko-green selection:text-white">
        <div class="min-h-screen flex">
            <!-- Left Side (Banner) - Hidden on mobile -->
            <div class="hidden lg:flex lg:w-1/2 bg-toko-green relative items-center justify-center overflow-hidden">
                <!-- Abstract decorative elements for a premium feel -->
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="absolute w-full h-full">
                        <polygon fill="white" points="0,100 100,0 100,100"/>
                    </svg>
                </div>
                <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-white opacity-20 rounded-full blur-3xl"></div>
                <div class="absolute top-1/4 right-10 w-72 h-72 bg-white opacity-10 rounded-full blur-2xl"></div>
                
                <div class="relative z-10 px-16 flex flex-col justify-center text-white h-full w-full">
                    <div class="mb-auto mt-12">
                        <a href="/" class="text-3xl font-extrabold tracking-tight flex items-center gap-2">
                            <!-- Simple Logo Icon -->
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            TokoKita
                        </a>
                    </div>
                    <div class="mb-32">
                        <h1 class="text-5xl font-extrabold tracking-tight mb-6 leading-tight">
                            Digitalisasi <br>
                            <span class="text-green-100">UMKM Indonesia</span>
                        </h1>
                        <p class="text-lg font-medium opacity-90 max-w-md leading-relaxed">
                            Platform e-commerce terbaik yang menghubungkan penjual lokal dengan pembeli di seluruh nusantara. Aman, mudah, dan menguntungkan.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Right Side (Form Container) -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative bg-gray-50 lg:bg-white">
                <!-- Mobile Logo (shown only on small screens) -->
                <div class="absolute top-8 left-8 lg:hidden">
                    <a href="/" class="text-3xl font-extrabold text-toko-green tracking-tight flex items-center gap-2">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        TokoKita
                    </a>
                </div>

                <div class="w-full max-w-md bg-white p-8 sm:p-10 rounded-2xl shadow-xl lg:shadow-none lg:p-0 lg:bg-transparent">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
