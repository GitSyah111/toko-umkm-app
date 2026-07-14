<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Platform Daily Summary') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Summary List</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.platform-summary.excel') }}" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 transition">Export Kinerja Platform (Excel)</a>
                            <a href="{{ route('admin.platform-summary.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Create New</a>
                        </div>
                    </div>
                    
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total GMV</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Orders</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Active Tokos</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($data as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->tanggal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($item->total_gmv, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->total_orders }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->total_active_tokos }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('admin.platform-summary.show', $item->id) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                            <a href="{{ route('admin.platform-summary.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('admin.platform-summary.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
