<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CancelledOrdersExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $tokoId;

    public function __construct(int $tokoId)
    {
        $this->tokoId = $tokoId;
    }

    public function collection()
    {
        return Order::with('user')
            ->where('toko_id', $this->tokoId)
            ->where('status', 'dibatalkan')
            ->orderBy('tanggal_order', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Pesanan',
            'Tanggal Dibatalkan',
            'Nama Pembeli',
            'Total Harga (Rp)',
            'Alasan Pembatalan',
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->updated_at ? $order->updated_at->format('d/m/Y H:i') : ($order->tanggal_order ? $order->tanggal_order->format('d/m/Y H:i') : ''),
            $order->user ? $order->user->name : 'Unknown',
            $order->total_bayar,
            $order->alasan_pembatalan ?? 'Dibatalkan',
        ];
    }
}
