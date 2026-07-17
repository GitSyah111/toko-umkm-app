<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewAnalysisController extends Controller
{
    public function index()
    {
        // 1. Rata-rata rating per produk
        $produks = Produk::withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->paginate(10);

        // 2. Distribusi rating untuk semua produk
        $ratingDistribution = DB::table('reviews')
            ->select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->pluck('total', 'rating')
            ->toArray();

        // Pastikan semua bintang 1-5 ada dalam array
        $chartData = [];
        for ($i = 1; $i <= 5; $i++) {
            $chartData[$i] = $ratingDistribution[$i] ?? 0;
        }

        // 3. Daftar ulasan terbaru yang perlu dimoderasi (status = pending)
        $recentReviews = Review::with(['user', 'produk'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10, ['*'], 'reviews_page');

        return view('admin.reviews.analysis', compact('produks', 'chartData', 'recentReviews'));
    }

    public function moderate(Request $request, Review $review)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending'
        ]);

        $review->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status ulasan berhasil diperbarui.');
    }
}
