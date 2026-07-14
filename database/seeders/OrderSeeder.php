<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [];
        $orderItems = [];
        $payments = [];
        
        $statuses = ['pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled'];
        $paymentMethods = ['bank_transfer', 'qris', 'ewallet'];

        $tokoProducts = [
            1 => range(1, 17),
            2 => range(18, 34),
            3 => range(35, 50),
        ];
        
        $orderIdCounter = 1;
        $orderItemIdCounter = 1;
        $paymentIdCounter = 1;
        
        $now = Carbon::now();
        // distribute orders over the last 30 days
        
        for ($i = 0; $i < 100; $i++) {
            $buyerId = rand(5, 14);
            $tokoId = rand(1, 3);
            
            $status = $statuses[array_rand($statuses)];
            $orderDate = clone $now;
            $orderDate->subDays(rand(1, 30))->subHours(rand(1, 23))->subMinutes(rand(1, 59));
            
            // Generate items
            $numItems = rand(1, 3);
            $totalHarga = 0;
            
            // Randomly select products from the toko
            $selectedProducts = (array) array_rand(array_flip($tokoProducts[$tokoId]), $numItems);
            
            foreach ($selectedProducts as $productId) {
                // Approximate price for simplicity (or we can query DB, but since we know the ranges, let's just make a mock price or query)
                // In seeder, querying DB inside a loop is fine for 100 records
                $product = DB::table('produks')->where('id', $productId)->first();
                $qty = rand(1, 5);
                $subtotal = $product->harga * $qty;
                
                $orderItems[] = [
                    'id' => $orderItemIdCounter++,
                    'order_id' => $orderIdCounter,
                    'product_id' => $productId,
                    'harga_satuan' => $product->harga,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ];
                
                $totalHarga += $subtotal;
            }
            
            $ongkir = rand(10, 50) * 1000;
            $totalBayar = $totalHarga + $ongkir;
            
            $orders[] = [
                'id' => $orderIdCounter,
                'user_id' => $buyerId,
                'toko_id' => $tokoId,
                'tanggal_order' => $orderDate,
                'status' => $status,
                'total_harga' => $totalHarga,
                'ongkir' => $ongkir,
                'total_bayar' => $totalBayar,
                'alamat_pengiriman' => 'Alamat Pembeli ' . $buyerId . ', Kota Tujuan',
                'resi_pengiriman' => in_array($status, ['shipped', 'completed']) ? 'RESI' . strtoupper(uniqid()) : null,
                'alasan_pembatalan' => $status === 'cancelled' ? 'Pembeli berubah pikiran' : null,
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ];
            
            // Payment
            $paymentStatus = 'success';
            if ($status === 'pending') $paymentStatus = 'pending';
            if ($status === 'cancelled') $paymentStatus = 'failed';
            
            $payments[] = [
                'id' => $paymentIdCounter++,
                'order_id' => $orderIdCounter,
                'metode_pembayaran' => $paymentMethods[array_rand($paymentMethods)],
                'jumlah' => $totalBayar,
                'tanggal_bayar' => $paymentStatus === 'success' ? (clone $orderDate)->addMinutes(rand(5, 60)) : null,
                'status' => $paymentStatus,
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ];
            
            $orderIdCounter++;
        }
        
        // Batch inserts
        foreach (array_chunk($orders, 50) as $chunk) {
            DB::table('orders')->insert($chunk);
        }
        
        foreach (array_chunk($orderItems, 50) as $chunk) {
            DB::table('order_items')->insert($chunk);
        }
        
        foreach (array_chunk($payments, 50) as $chunk) {
            DB::table('payments')->insert($chunk);
        }
        
        // Build Summaries from generated data
        $this->buildSummaries();
    }

    private function buildSummaries(): void
    {
        // Daily summaries for toko
        $tokoSummaries = DB::table('orders')
            ->select(DB::raw('toko_id, DATE(tanggal_order) as tanggal, SUM(total_harga) as total_revenue, COUNT(id) as total_orders'))
            ->whereIn('status', ['paid', 'processing', 'shipped', 'completed'])
            ->groupBy('toko_id', DB::raw('DATE(tanggal_order)'))
            ->get();
            
        $tokoData = [];
        $now = Carbon::now();
        foreach ($tokoSummaries as $ts) {
            $tokoData[] = [
                'toko_id' => $ts->toko_id,
                'tanggal' => $ts->tanggal,
                'total_revenue' => $ts->total_revenue,
                'total_orders' => $ts->total_orders,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        
        if (!empty($tokoData)) {
            DB::table('toko_daily_summaries')->insert($tokoData);
        }
        
        // Daily summaries for platform
        $platformSummaries = DB::table('orders')
            ->select(DB::raw('DATE(tanggal_order) as tanggal, SUM(total_harga) as total_gmv, COUNT(id) as total_orders, COUNT(DISTINCT toko_id) as total_active_tokos'))
            ->whereIn('status', ['paid', 'processing', 'shipped', 'completed'])
            ->groupBy(DB::raw('DATE(tanggal_order)'))
            ->get();
            
        $platformData = [];
        foreach ($platformSummaries as $ps) {
            $platformData[] = [
                'tanggal' => $ps->tanggal,
                'total_gmv' => $ps->total_gmv,
                'total_orders' => $ps->total_orders,
                'total_active_tokos' => $ps->total_active_tokos,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        
        if (!empty($platformData)) {
            DB::table('platform_daily_summaries')->insert($platformData);
        }
    }
}
