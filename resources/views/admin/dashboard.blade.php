<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Admin') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.dashboard', ['refresh' => 1]) }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm transition ease-in-out duration-150">
                    Refresh Data
                </a>
                <a href="{{ route('admin.users.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition ease-in-out duration-150">
                    Manajemen Pengguna
                </a>
                <a href="{{ route('admin.categories.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm transition ease-in-out duration-150">
                    Manajemen Kategori
                </a>
            </div>
        </div>
        <!-- Meta refresh for real-time KPI 5 minutes -->
        <meta http-equiv="refresh" content="300">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-semibold uppercase">GMV Bulan Ini</div>
                    <div class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($totalGmvBulanIni, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Total Transaksi Selesai</div>
                    <div class="text-3xl font-bold text-blue-600 mt-2">{{ $totalTransaksiBulanIni }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500 text-sm font-semibold uppercase">Total Toko di Platform</div>
                    <div class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalToko }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Line Chart: Tren GMV -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Tren GMV Platform (6 Bulan)</h3>
                    <canvas id="gmvTrendChart"></canvas>
                </div>

                <!-- Bar Chart: Pendaftaran Toko Baru -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Pendaftaran Toko Baru (6 Bulan)</h3>
                    <canvas id="newShopsChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Data dari Controller
            const gmvTrendData = @json($gmvTrend);
            const newShopsData = @json($newShopsTrend);

            // 1. Line Chart - Tren GMV
            new Chart(document.getElementById('gmvTrendChart'), {
                type: 'line',
                data: {
                    labels: gmvTrendData.labels,
                    datasets: [{
                        label: 'GMV (Rp)',
                        data: gmvTrendData.data,
                        borderColor: 'rgb(54, 162, 235)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
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

            // 2. Bar Chart - Pendaftaran Toko Baru
            new Chart(document.getElementById('newShopsChart'), {
                type: 'bar',
                data: {
                    labels: newShopsData.labels,
                    datasets: [{
                        label: 'Jumlah Toko Baru',
                        data: newShopsData.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
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
