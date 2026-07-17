<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\PlatformDailySummary;
use App\Models\TokoDailySummary;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateDailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summary {--date= : The date to generate summary for (Y-m-d)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate daily summary for toko and platform';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dateStr = $this->option('date') ?: Carbon::yesterday()->toDateString();
        $date = Carbon::parse($dateStr);
        
        $this->info("Generating summary for date: {$date->toDateString()}");

        $orders = Order::with('items')
            ->whereDate('tanggal_order', $date->toDateString())
            ->where('status', 'selesai')
            ->get();

        $tokoOrders = $orders->groupBy('toko_id');
        
        $totalPlatformGmv = 0;
        $totalPlatformOrders = $orders->count();
        $totalActiveTokos = $tokoOrders->count();

        foreach ($tokoOrders as $tokoId => $tokoOrderGroup) {
            $totalRevenue = $tokoOrderGroup->sum('total_harga');
            $totalGmvPerToko = $tokoOrderGroup->sum('total_bayar');
            $totalPlatformGmv += $totalGmvPerToko;
            $totalTokoOrders = $tokoOrderGroup->count();
            
            $totalHpp = 0;
            foreach ($tokoOrderGroup as $order) {
                foreach ($order->items as $item) {
                    $totalHpp += ($item->hpp_satuan ?? 0) * $item->qty;
                }
            }

            TokoDailySummary::updateOrCreate(
                ['toko_id' => $tokoId, 'tanggal' => $date->toDateString()],
                [
                    'total_revenue' => $totalRevenue,
                    'total_hpp' => $totalHpp,
                    'total_orders' => $totalTokoOrders,
                ]
            );
        }

        PlatformDailySummary::updateOrCreate(
            ['tanggal' => $date->toDateString()],
            [
                'total_gmv' => $totalPlatformGmv,
                'total_orders' => $totalPlatformOrders,
                'total_active_tokos' => $totalActiveTokos,
            ]
        );

        $this->info("Summary generated successfully!");
    }
}
