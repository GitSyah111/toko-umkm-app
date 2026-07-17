<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Analisis Ulasan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tabel Rata-rata Rating -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Rata-rata Rating per Produk</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($produks as $produk)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $produk->nama_produk }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold text-yellow-500">
                                            {{ number_format($produk->reviews_avg_rating, 1) }} ★
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">Belum ada ulasan produk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $produks->links() }}
                    </div>
                </div>

                <!-- Bar Chart Distribusi Rating -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">Distribusi Rating (Keseluruhan)</h3>
                    <canvas id="ratingDistributionChart"></canvas>
                </div>
            </div>

            <!-- Daftar Ulasan Menunggu Moderasi -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Ulasan Terbaru (Perlu Dimoderasi)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produk</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komentar</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentReviews as $review)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $review->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $review->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $review->produk->nama_produk ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-yellow-500">{{ $review->rating }} ★</td>
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">{{ $review->komentar ?: '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <form action="{{ route('admin.reviews.moderate', $review->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-xs mr-2">Setujui</button>
                                        </form>
                                        <form action="{{ route('admin.reviews.moderate', $review->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-xs" onclick="return confirm('Tolak ulasan ini?')">Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada ulasan yang perlu dimoderasi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $recentReviews->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chartDataRaw = @json($chartData);
            
            // Konversi object ke array sesuai urutan 1, 2, 3, 4, 5
            const labels = ['1 Bintang', '2 Bintang', '3 Bintang', '4 Bintang', '5 Bintang'];
            const data = [
                chartDataRaw['1'] || 0,
                chartDataRaw['2'] || 0,
                chartDataRaw['3'] || 0,
                chartDataRaw['4'] || 0,
                chartDataRaw['5'] || 0
            ];

            new Chart(document.getElementById('ratingDistributionChart'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Ulasan',
                        data: data,
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.7)',  // 1 star - Red
                            'rgba(249, 115, 22, 0.7)', // 2 star - Orange
                            'rgba(234, 179, 8, 0.7)',  // 3 star - Yellow
                            'rgba(132, 204, 22, 0.7)', // 4 star - Lime
                            'rgba(34, 197, 94, 0.7)'   // 5 star - Green
                        ],
                        borderWidth: 1
                    }]
                },
                options: { 
                    responsive: true,
                    scales: {
                        y: { 
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
