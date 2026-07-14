<?php

namespace App\Exports;

use App\Models\Produk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LowStockExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $tokoId;
    protected $threshold;

    public function __construct(int $tokoId, int $threshold = 5)
    {
        $this->tokoId = $tokoId;
        $this->threshold = $threshold;
    }

    public function collection()
    {
        return Produk::with('kategori')
            ->where('toko_id', $this->tokoId)
            ->where('stok', '<=', $this->threshold)
            ->orderBy('stok', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Produk',
            'Nama Produk',
            'Kategori',
            'Harga Jual (Rp)',
            'Sisa Stok',
        ];
    }

    public function map($produk): array
    {
        return [
            $produk->id,
            $produk->nama,
            $produk->kategori ? $produk->kategori->nama : 'Tanpa Kategori',
            $produk->harga_jual,
            $produk->stok,
        ];
    }
}
