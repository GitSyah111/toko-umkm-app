<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformDailySummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'total_gmv',
        'total_orders',
        'total_active_tokos',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
