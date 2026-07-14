<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Platform Daily Summary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Summary Details</h3>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-md">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <span class="block text-sm font-medium text-gray-500">Tanggal</span>
                                <span class="block mt-1 text-sm text-gray-900">{{ $data->tanggal }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-500">Total GMV</span>
                                <span class="block mt-1 text-sm text-gray-900">Rp {{ number_format($data->total_gmv, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-500">Total Orders</span>
                                <span class="block mt-1 text-sm text-gray-900">{{ $data->total_orders }}</span>
                            </div>
                            <div>
                                <span class="block text-sm font-medium text-gray-500">Total Active Tokos</span>
                                <span class="block mt-1 text-sm text-gray-900">{{ $data->total_active_tokos }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <a href="{{ route('admin.platform-summary.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">Back to List</a>
                        <a href="{{ route('admin.platform-summary.edit', $data->id) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">Edit Summary</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
