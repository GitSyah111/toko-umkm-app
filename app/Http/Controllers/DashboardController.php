<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Produk;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'penjual') {
            return $this->sellerDashboard($user);
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Default for buyer
        return view('dashboard');
    }

    private function sellerDashboard($user)
    {
        $toko = $user->toko;

        if (!$toko) {
            return view('seller.dashboard', ['has_toko' => false]);
        }

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // KPI
        $omsetBulanIni = Order::where('toko_id', $toko->id)
            ->where('status', 'selesai')
            ->whereBetween('tanggal_order', [$startOfMonth, $endOfMonth])
            ->sum('total_harga'); // atau total_bayar jika termasuk ongkir, scope mengatakan omset penjualan

        $pesananBaru = Order::where('toko_id', $toko->id)
            ->whereIn('status', ['menunggu pembayaran', 'diproses'])
            ->count();

        $totalProduk = Produk::where('toko_id', $toko->id)->count();

        // 6. Grafik Pertumbuhan Penjualan (Line Chart - 6 Bulan Terakhir)
        $salesGrowth = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $total = Order::where('toko_id', $toko->id)
                ->where('status', 'selesai')
                ->whereYear('tanggal_order', $month->year)
                ->whereMonth('tanggal_order', $month->month)
                ->sum('total_harga');
            
            $salesGrowth['labels'][] = $month->translatedFormat('F Y');
            $salesGrowth['data'][] = $total;
        }

        // 7. Laporan Produk Terlaris (Pie/Doughnut Chart)
        $bestSellers = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('produks', 'order_items.product_id', '=', 'produks.id')
            ->where('orders.toko_id', $toko->id)
            ->where('orders.status', 'selesai')
            ->select('produks.nama_produk', DB::raw('SUM(order_items.qty) as total_qty'))
            ->groupBy('produks.id', 'produks.nama_produk')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $bestSellerChart = [
            'labels' => $bestSellers->pluck('nama_produk')->toArray(),
            'data' => $bestSellers->pluck('total_qty')->toArray()
        ];

        // 8. Statistik Status Pesanan (Bar/Donut Chart) - Bulan Terakhir
        $orderStatsData = Order::where('toko_id', $toko->id)
            ->whereBetween('tanggal_order', [$startOfMonth, $endOfMonth])
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusLabels = ['Selesai', 'Diproses', 'Dibatalkan', 'Menunggu Pembayaran', 'Dikirim'];
        $orderStatsChart = [
            'labels' => $statusLabels,
            'data' => collect($statusLabels)->map(function ($status) use ($orderStatsData) {
                return $orderStatsData[strtolower($status)] ?? ($orderStatsData[$status] ?? 0);
            })->toArray()
        ];

        // 9. Peringatan Stok Menipis (Dashboard Alert)
        $lowStockProducts = Produk::where('toko_id', $toko->id)
            ->where('stok', '<=', 5) // batas minimum stok 5
            ->orderBy('stok', 'asc')
            ->get();

        $has_toko = true;

        return view('seller.dashboard', compact(
            'has_toko',
            'toko',
            'omsetBulanIni',
            'pesananBaru',
            'totalProduk',
            'salesGrowth',
            'bestSellerChart',
            'orderStatsChart',
            'lowStockProducts'
        ));
    }
}
