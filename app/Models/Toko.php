<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Toko extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'nama_toko',
        'deskripsi',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function dailySummaries()
    {
        return $this->hasMany(TokoDailySummary::class);
    }
}
