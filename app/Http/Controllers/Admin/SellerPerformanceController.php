<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SellerPerformanceController extends Controller
{
    public function index()
    {
        // Mendapatkan data 3 bulan terakhir
        $threeMonthsAgo = Carbon::now()->subMonths(3)->startOfDay();

        // Mengambil data pesanan selesai dalam 3 bulan terakhir, dikelompokkan berdasarkan toko_id
        $sellerPerformances = Order::where('status', 'selesai')
            ->where('tanggal_order', '>=', $threeMonthsAgo)
            ->select('toko_id', DB::raw('count(id) as total_pesanan'), DB::raw('sum(total_harga) as total_omzet'))
            ->groupBy('toko_id')
            ->with('toko')
            ->orderBy('total_omzet', 'desc')
            ->get();

        // Menyiapkan data untuk Chart.js
        $chartLabels = [];
        $chartData = [];

        foreach ($sellerPerformances as $performance) {
            $chartLabels[] = $performance->toko ? $performance->toko->nama_toko : 'Toko Tidak Dikenal';
            $chartData[] = $performance->total_omzet;
        }

        return view('admin.seller-performance.index', compact('sellerPerformances', 'chartLabels', 'chartData'));
    }
}
