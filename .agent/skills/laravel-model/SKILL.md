---
name: Laravel Model Convention
description: Memandu konvensi penulisan Model Eloquent Laravel untuk proyek Toko UMKM
---

# Konvensi Model Eloquent

Skill ini mendokumentasikan pola dan konvensi standar yang harus diikuti ketika membuat atau memodifikasi Model Eloquent dalam proyek Toko UMKM.

## Struktur Dasar

Setiap model harus berada di namespace `App\Models` dan mewarisi `Illuminate\Database\Eloquent\Model`. Model juga harus menggunakan trait `HasFactory`.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamaModel extends Model
{
    use HasFactory;
    
    // ...
}
```

## Properti

1. **`$fillable`**: Wajib mendefinisikan array `$fillable` untuk semua atribut yang diizinkan untuk mass assignment. Hindari penggunaan `$guarded` untuk keamanan yang lebih eksplisit.
2. **`$casts`**: Gunakan `$casts` untuk melakukan konversi tipe data secara otomatis, terutama untuk tipe tanggal (`date`, `datetime`), boolean, atau array/json.

```php
    protected $fillable = [
        'kolom_1',
        'kolom_2',
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'is_active' => 'boolean',
    ];
```

## Relasi (Relationships)

1. **Penamaan Method**: Nama method relasi menggunakan `camelCase`. Gunakan bentuk tunggal (singular) untuk relasi `belongsTo` atau `hasOne`, dan bentuk jamak (plural) untuk `hasMany` atau `belongsToMany`.
2. **Pengembalian (Return)**: Kembalikan secara langsung instance dari pemanggilan method relasi Laravel.
3. **Foreign Key Eksplisit**: Jika nama method relasi tidak dapat dipetakan secara otomatis ke foreign key oleh Laravel (misalnya method bernama `produk()` untuk merujuk ke tabel products, namun foreign key-nya adalah `product_id`), maka foreign key tersebut harus dideklarasikan secara eksplisit pada parameter kedua.

```php
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }
```
