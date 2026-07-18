<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun Baru</h2>
        <p class="text-base text-gray-600">Bergabunglah dengan TokoKita dan mulai perjalanan bisnis Anda.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="font-medium text-gray-700" />
            <x-text-input id="name" class="block mt-2 w-full px-4 py-3 rounded-xl border-gray-300 focus:border-toko-green focus:ring focus:ring-toko-green focus:ring-opacity-20 transition duration-200 shadow-sm" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="font-medium text-gray-700" />
            <x-text-input id="email" class="block mt-2 w-full px-4 py-3 rounded-xl border-gray-300 focus:border-toko-green focus:ring focus:ring-toko-green focus:ring-opacity-20 transition duration-200 shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="contoh@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="font-medium text-gray-700" />
            <x-text-input id="password" class="block mt-2 w-full px-4 py-3 rounded-xl border-gray-300 focus:border-toko-green focus:ring focus:ring-toko-green focus:ring-opacity-20 transition duration-200 shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="font-medium text-gray-700" />
            <x-text-input id="password_confirmation" class="block mt-2 w-full px-4 py-3 rounded-xl border-gray-300 focus:border-toko-green focus:ring focus:ring-toko-green focus:ring-opacity-20 transition duration-200 shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm text-base font-semibold text-white bg-toko-green hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-toko-green transition duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                {{ __('Daftar Sekarang') }}
            </button>
        </div>
        
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-semibold text-toko-green hover:text-green-700 transition duration-200">Masuk di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
