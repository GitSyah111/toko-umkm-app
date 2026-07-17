<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Penjual') }}
        </h2>
        <!-- Meta refresh for real-time KPI 5 minutes -->
        <meta http-equiv="refresh" content="300">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(isset($has_toko) && !$has_toko)
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                    <p class="font-bold">Perhatian</p>
                    <p>Anda belum memiliki toko. Silakan buat toko terlebih dahulu.</p>
                </div>
            @else

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Omset Bulan Ini</div>
                    <div class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($omsetBulanIni, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Pesanan Baru</div>
                    <div class="text-3xl font-bold text-blue-600 mt-2">{{ $pesananBaru }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Total Produk</div>
                    <div class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalProduk }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Line Chart: Pertumbuhan Penjualan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Pertumbuhan Penjualan (6 Bulan)</h3>
                    <canvas id="salesGrowthChart"></canvas>
                </div>

                <!-- Pie Chart: Produk Terlaris -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">5 Produk Terlaris</h3>
                    <canvas id="bestSellerChart"></canvas>
                </div>
                
                <!-- Donut Chart: Statistik Status Pesanan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Statistik Status Pesanan (Bulan Ini)</h3>
                    <canvas id="orderStatsChart"></canvas>
                </div>

                <!-- Peringatan Stok Menipis -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-red-600 mb-4">Peringatan Stok Menipis</h3>
                    @if(count($lowStockProducts) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase">Produk</th>
                                        <th class="py-2 px-4 border-b text-left text-xs font-semibold text-gray-600 uppercase">Sisa Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lowStockProducts as $produk)
                                        <tr>
                                            <td class="py-2 px-4 border-b text-sm">{{ $produk->nama_produk }}</td>
                                            <td class="py-2 px-4 border-b text-sm font-bold text-red-500">{{ $produk->stok }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Stok semua produk aman (> 5).</p>
                    @endif
                </div>
            </div>

            @endif
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if(isset($has_toko) && $has_toko)
            
            // Data dari Controller
            const salesGrowthData = @json($salesGrowth);
            const bestSellerData = @json($bestSellerChart);
            const orderStatsData = @json($orderStatsChart);

            // 1. Line Chart - Pertumbuhan Penjualan
            new Chart(document.getElementById('salesGrowthChart'), {
                type: 'line',
                data: {
                    labels: salesGrowthData.labels,
                    datasets: [{
                        label: 'Omset Penjualan (Rp)',
                        data: salesGrowthData.data,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // 2. Pie Chart - Produk Terlaris
            new Chart(document.getElementById('bestSellerChart'), {
                type: 'pie',
                data: {
                    labels: bestSellerData.labels,
                    datasets: [{
                        data: bestSellerData.data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: { responsive: true }
            });

            // 3. Donut Chart - Statistik Status Pesanan
            new Chart(document.getElementById('orderStatsChart'), {
                type: 'doughnut',
                data: {
                    labels: orderStatsData.labels,
                    datasets: [{
                        data: orderStatsData.data,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.7)', // Selesai - Hijau
                            'rgba(54, 162, 235, 0.7)', // Diproses - Biru
                            'rgba(255, 99, 132, 0.7)', // Dibatalkan - Merah
                            'rgba(255, 206, 86, 0.7)', // Menunggu Pembayaran - Kuning
                            'rgba(153, 102, 255, 0.7)' // Dikirim - Ungu
                        ],
                        borderWidth: 1
                    }]
                },
                options: { responsive: true }
            });

            @endif
        });
    </script>
</x-app-layout>
