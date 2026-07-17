<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'toko_id',
        'nama_produk',
        'category_id',
        'deskripsi',
        'harga_pokok',
        'harga',
        'stok',
        'berat',
        'gambar',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('nama_produk', 'like', '%' . $search . '%');
        });

        $query->when($filters['category_id'] ?? false, function ($query, $categoryId) {
            return $query->where('category_id', $categoryId);
        });

        $query->when($filters['min_harga'] ?? false, function ($query, $minHarga) {
            return $query->where('harga', '>=', $minHarga);
        });

        $query->when($filters['max_harga'] ?? false, function ($query, $maxHarga) {
            return $query->where('harga', '<=', $maxHarga);
        });
    }
}
