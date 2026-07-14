<?php

namespace App\Exports;

use App\Models\TokoDailySummary;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SalesRecapExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $tokoId;

    public function __construct(int $tokoId)
    {
        $this->tokoId = $tokoId;
    }

    public function collection()
    {
        return TokoDailySummary::where('toko_id', $this->tokoId)
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Total Pesanan',
            'Total Omset (Rp)',
        ];
    }

    public function map($summary): array
    {
        return [
            $summary->tanggal->format('d/m/Y'),
            $summary->total_orders,
            $summary->total_revenue,
        ];
    }
}
