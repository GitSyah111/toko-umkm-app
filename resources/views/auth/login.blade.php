<x-guest-layout>
    <div class="mb-10">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h2>
        <p class="text-base text-gray-600">Masuk ke akun Anda untuk mulai berbelanja atau mengelola toko.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="font-medium text-gray-700" />
            <x-text-input id="email" class="block mt-2 w-full px-4 py-3 rounded-xl border-gray-300 focus:border-toko-green focus:ring focus:ring-toko-green focus:ring-opacity-20 transition duration-200 shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="contoh@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-2">
                <x-input-label for="password" :value="__('Password')" class="font-medium text-gray-700" />
                @if (Route::has('password.request'))
                    <a class="text-sm text-toko-green hover:text-green-700 font-semibold transition duration-200" href="{{ route('password.request') }}">
                        {{ __('Lupa password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block w-full px-4 py-3 rounded-xl border-gray-300 focus:border-toko-green focus:ring focus:ring-toko-green focus:ring-opacity-20 transition duration-200 shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-5 h-5 rounded border-gray-300 text-toko-green shadow-sm focus:ring-toko-green focus:ring-opacity-50 transition duration-200" name="remember">
                <span class="ms-3 text-sm text-gray-600 select-none">{{ __('Ingat saya') }}</span>
            </label>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-base font-semibold text-white bg-toko-green hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-toko-green transition duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                {{ __('Masuk') }}
            </button>
        </div>
        
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-semibold text-toko-green hover:text-green-700 transition duration-200">Daftar sekarang</a>
            </p>
        </div>
    </form>
</x-guest-layout>
