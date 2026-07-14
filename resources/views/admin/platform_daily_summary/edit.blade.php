<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Platform Daily Summary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.platform-summary.update', $data->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <x-input-label for="tanggal" :value="__('Tanggal')" />
                            <x-text-input id="tanggal" class="block mt-1 w-full bg-gray-100" type="date" name="tanggal" :value="old('tanggal', $data->tanggal->format('Y-m-d'))" required autofocus readonly />
                            <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="total_gmv" :value="__('Total GMV (Rp)')" />
                            <x-text-input id="total_gmv" class="block mt-1 w-full" type="number" step="0.01" name="total_gmv" :value="old('total_gmv', $data->total_gmv)" required />
                            <x-input-error :messages="$errors->get('total_gmv')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="total_orders" :value="__('Total Orders')" />
                            <x-text-input id="total_orders" class="block mt-1 w-full" type="number" name="total_orders" :value="old('total_orders', $data->total_orders)" required />
                            <x-input-error :messages="$errors->get('total_orders')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="total_active_tokos" :value="__('Total Active Tokos')" />
                            <x-text-input id="total_active_tokos" class="block mt-1 w-full" type="number" name="total_active_tokos" :value="old('total_active_tokos', $data->total_active_tokos)" required />
                            <x-input-error :messages="$errors->get('total_active_tokos')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4" href="{{ route('admin.platform-summary.index') }}">
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
