<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Toko;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('refresh')) {
            Cache::forget('admin_dashboard_data');
            return redirect()->route('admin.dashboard')->with('success', 'Data dashboard berhasil diperbarui.');
        }

        $dashboardData = Cache::remember('admin_dashboard_data', 600, function () {
            $now = Carbon::now();
            $startOfMonth = $now->copy()->startOfMonth();
            $endOfMonth = $now->copy()->endOfMonth();

            // KPI
            $totalGmvBulanIni = Order::where('status', 'selesai')
                ->whereBetween('tanggal_order', [$startOfMonth, $endOfMonth])
                ->sum('total_harga');

            $totalTransaksiBulanIni = Order::where('status', 'selesai')
                ->whereBetween('tanggal_order', [$startOfMonth, $endOfMonth])
                ->count();

            $totalToko = Toko::count();

            // Grafik Tren GMV (6 Bulan Terakhir)
            $gmvTrend = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = $now->copy()->subMonths($i);
                $total = Order::where('status', 'selesai')
                    ->whereYear('tanggal_order', $month->year)
                    ->whereMonth('tanggal_order', $month->month)
                    ->sum('total_harga');
                
                $gmvTrend['labels'][] = $month->translatedFormat('F Y');
                $gmvTrend['data'][] = $total;
            }

            // Grafik Pendaftaran Toko Baru (6 Bulan Terakhir)
            $newShopsTrend = [];
            for ($i = 5; $i >= 0; $i--) {
                $month = $now->copy()->subMonths($i);
                $count = Toko::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count();
                
                $newShopsTrend['labels'][] = $month->translatedFormat('F Y');
                $newShopsTrend['data'][] = $count;
            }

            return compact(
                'totalGmvBulanIni',
                'totalTransaksiBulanIni',
                'totalToko',
                'gmvTrend',
                'newShopsTrend'
            );
        });

        return view('admin.dashboard', $dashboardData);
    }
}
