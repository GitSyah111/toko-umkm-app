<?php

namespace App\Exports;

use App\Models\PlatformDailySummary;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PlatformPerformanceExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return PlatformDailySummary::orderBy('tanggal', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Total GMV (Rp)',
            'Total Pesanan',
            'Total Toko Aktif/Baru',
        ];
    }

    public function map($summary): array
    {
        return [
            $summary->tanggal->format('d/m/Y'),
            $summary->total_gmv,
            $summary->total_orders,
            $summary->total_active_tokos,
        ];
    }
}
