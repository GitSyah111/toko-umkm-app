<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokoDailySummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'toko_id',
        'tanggal',
        'total_revenue',
        'total_orders',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }
}
