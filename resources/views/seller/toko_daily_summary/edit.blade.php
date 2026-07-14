<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Toko Daily Summary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('seller.toko-summary.update', $data->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <x-input-label for="tanggal" :value="__('Tanggal')" />
                            <x-text-input id="tanggal" class="block mt-1 w-full bg-gray-100" type="date" name="tanggal" :value="old('tanggal', $data->tanggal->format('Y-m-d'))" required autofocus readonly />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="total_revenue" :value="__('Total Revenue (Rp)')" />
                            <x-text-input id="total_revenue" class="block mt-1 w-full" type="number" step="0.01" name="total_revenue" :value="old('total_revenue', $data->total_revenue)" required />
                            <x-input-error :messages="$errors->get('total_revenue')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="total_orders" :value="__('Total Orders')" />
                            <x-text-input id="total_orders" class="block mt-1 w-full" type="number" name="total_orders" :value="old('total_orders', $data->total_orders)" required />
                            <x-input-error :messages="$errors->get('total_orders')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4" href="{{ route('seller.toko-summary.index') }}">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
