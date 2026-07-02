# Laravel 10 Migration Skill (Toko UMKM)

Skill ini memandu AI Agent dalam membuat file migration Laravel 10 yang konsisten secara ketat dengan desain ERD di `docs/database/erd.dbml`. 

## Aturan Pembuatan Migration

### 1. Urutan Pembuatan Tabel
Urutan pembuatan tabel pada saat migrasi berjalan (urutan file atau penempatan dalam satu file) sangat krusial untuk mencegah error _Foreign Key Constraint_. Buat file migration berdasarkan urutan dependensi dari tabel master hingga ke tabel relasi/transaksi:
1. `users` (Tabel Utama, tidak punya FK)
2. `tokos` (Bergantung pada `users`)
3. `carts` (Bergantung pada `users`)
4. `produks` (Bergantung pada `tokos`)
5. `cart_items` (Bergantung pada `carts` dan `produks`)
6. `orders` (Bergantung pada `users` dan `tokos`)
7. `order_items` (Bergantung pada `orders` dan `produks`)
8. `payments` (Bergantung pada `orders`)

### 2. Konvensi Tipe Data (MySQL to Laravel Schema)
Perhatikan pemetaan tipe data DBML ke *schema builder* Laravel:
- `bigint [primary key, increment]` ➔ `$table->id();`
- `varchar` ➔ `$table->string('column_name');`
- `text` ➔ `$table->text('column_name');`
- `double` ➔ `$table->double('column_name');`
- `int` ➔ `$table->integer('column_name');`
- `datetime` ➔ `$table->dateTime('column_name');`

> **Note:** Jika suatu kolom tidak ditandai `[not null]` secara eksplisit dan sifatnya logis bisa kosong di ERD, gunakan method `->nullable()`.

### 3. Timestamps & Soft Deletes
Perhatikan kolom yang terkait dengan waktu dan penghapusan logis:
- **Timestamps**: Jika ERD mencantumkan `created_at` dan `updated_at`, gunakan `$table->timestamps();`. Jangan mendefinisikan field ini satu-persatu.
- **Soft Deletes**: Jika ERD mencantumkan `deleted_at timestamp [note: 'Soft delete']`, gunakan method `$table->softDeletes();`. Pastikan Model terkait nanti menggunakan trait `SoftDeletes`.

### 4. Foreign Key Constraints
Semua baris referensi (misal: `Ref: users.id - tokos.user_id`) wajib diwujudkan dalam _Foreign Key constraint_.
Gunakan standard penulisan di Laravel 10:
`$table->foreignId('foreign_id')->constrained('table_name')->cascadeOnDelete();`
*(Gunakan cascade delete secara default untuk tabel pivot atau jika penghapusan induk sebaiknya menghapus data di bawahnya)*.

---

## Contoh Pola (Design Patterns)

### A. Pola Tabel Transaksi
Tabel transaksi (misal: `orders`, `payments`) sering melibatkan status (string/enum), catatan, dan rekaman nilai uang (double/decimal) pada saat itu:
```php
Schema::create('orders', function (Blueprint $table) {
    $table->id();
    
    // Foreign keys
    $table->foreignId('user_id')->constrained('users');
    $table->foreignId('toko_id')->constrained('tokos');
    
    // Atribut spesifik transaksi
    $table->dateTime('tanggal_order');
    $table->string('status'); 
    $table->double('total_harga');
    $table->double('ongkir');
    $table->double('total_bayar');
    $table->text('alamat_pengiriman');
    
    // Kolom opsional (karena tidak pasti not null saat dibuat)
    $table->string('resi_pengiriman')->nullable();
    $table->text('alasan_pembatalan')->nullable();
    
    $table->timestamps();
    $table->softDeletes();
});
```

### B. Pola Tabel Pivot / Relasi Detail
Tabel pivot atau relasi (misal: `cart_items`, `order_items`) menghubungkan setidaknya dua tabel utama. Biasakan menggunakan `cascadeOnDelete` atau `cascadeOnUpdate` agar konsistensi data terjaga.
```php
Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    
    // FK untuk tabel pivot yang merujuk pada master (seringkali butuh cascade)
    $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
    $table->foreignId('product_id')->constrained('produks')->cascadeOnDelete();
    
    // Atribut tambahan pada pivot
    $table->double('harga_satuan');
    $table->integer('qty');
    $table->double('subtotal');
    
    $table->timestamps();
});
```

### C. Pola Index Komposit & Unik
Jika ERD mencantumkan `[unique]` pada kolom (seperti `user_id` di `tokos`), maka wajib ditambahkan constraint unik. Jika aplikasi kemungkinan membutuhkan query filter berbarengan, buat index komposit.
```php
Schema::create('tokos', function (Blueprint $table) {
    $table->id();
    
    // Constraint Unique (One-to-One dengan user)
    $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
    
    $table->string('nama_toko');
    $table->text('deskripsi')->nullable();
    $table->text('alamat')->nullable();
    
    // Contoh Composite Index jika ada skenario pencarian user & toko spesifik
    // $table->index(['user_id', 'nama_toko']);
    
    $table->timestamps();
    $table->softDeletes();
});
```
