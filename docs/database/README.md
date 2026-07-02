# Toko UMKM Database ERD

Dokumen ini menjelaskan struktur database dan relasi antar tabel (Entity Relationship Diagram) untuk sistem Toko UMKM berdasarkan Class Diagram, dengan menerapkan konvensi penamaan Laravel.

## Relasi Antar Tabel

### 1. `users` ke `tokos`
- **Jenis Relasi:** One-to-One (`1` ke `0..1`)
- **Penjelasan:** Seorang `User` (pengguna) dapat memiliki maksimal satu `Toko`. Relasi ini menggunakan foreign key `user_id` pada tabel `tokos`.

### 2. `users` ke `carts`
- **Jenis Relasi:** One-to-One (`1` ke `1`)
- **Penjelasan:** Setiap `User` secara spesifik memiliki satu `Cart` (keranjang belanja). Relasi ini menggunakan foreign key `user_id` pada tabel `carts`.

### 3. `users` ke `orders`
- **Jenis Relasi:** One-to-Many (`1` ke `0..*`)
- **Penjelasan:** Seorang `User` dapat melakukan banyak `Order` (pesanan). Relasi ini menggunakan foreign key `user_id` pada tabel `orders`.

### 4. `tokos` ke `produks`
- **Jenis Relasi:** One-to-Many (`1` ke `0..*`)
- **Penjelasan:** Sebuah `Toko` dapat menjual berbagai jenis `Produk`. Relasi ini menggunakan foreign key `toko_id` pada tabel `produks`.

### 5. `tokos` ke `orders`
- **Jenis Relasi:** One-to-Many (`1` ke `0..*`)
- **Penjelasan:** Sebuah `Toko` dapat menerima banyak `Order` dari pembeli. Relasi ini menggunakan foreign key `toko_id` pada tabel `orders`.

### 6. `carts` ke `cart_items`
- **Jenis Relasi:** One-to-Many (`1` ke `0..*`)
- **Penjelasan:** Sebuah `Cart` (keranjang) dapat berisi banyak `CartItem` (item keranjang). Relasi ini menggunakan foreign key `cart_id` pada tabel `cart_items`.

### 7. `cart_items` ke `produks`
- **Jenis Relasi:** Many-to-One (`0..*` ke `1`)
- **Penjelasan:** Banyak `CartItem` bisa merujuk ke satu `Produk` yang sama (meskipun berada di keranjang pengguna yang berbeda). Relasi ini menggunakan foreign key `product_id` pada tabel `cart_items`.

### 8. `orders` ke `order_items`
- **Jenis Relasi:** One-to-Many (`1` ke `1..*`)
- **Penjelasan:** Sebuah `Order` setidaknya harus memiliki satu atau banyak `OrderItem` (detail pesanan). Relasi ini menggunakan foreign key `order_id` pada tabel `order_items`.

### 9. `order_items` ke `produks`
- **Jenis Relasi:** Many-to-One (`0..*` ke `1`)
- **Penjelasan:** Banyak `OrderItem` (dari berbagai pesanan) merujuk ke satu `Produk` yang dipesan. Relasi ini menggunakan foreign key `product_id` pada tabel `order_items`.

### 10. `orders` ke `payments`
- **Jenis Relasi:** One-to-One (`1` ke `0..1`)
- **Penjelasan:** Sebuah `Order` terkait dengan maksimal satu `Payment` (pembayaran). Relasi ini menggunakan foreign key `order_id` pada tabel `payments`.

## Fitur Laravel Conventions
- **Naming Convention:** Semua nama tabel telah dikonversi ke dalam format *snake_case* jamak (*plural*), seperti: `users`, `tokos`, `produks`, `carts`, `cart_items`, `orders`, `order_items`, `payments`.
- **Timestamps:** Kolom `created_at` dan `updated_at` (tipe data `timestamp`) ditambahkan di semua tabel untuk fitur pencatatan otomatis aktivitas.
- **Soft Delete:** Kolom `deleted_at` (tipe data `timestamp` nullable) telah ditambahkan di beberapa tabel utama (seperti `users`, `tokos`, `produks`, `orders`) untuk mendukung fitur Soft Delete di Eloquent (data tidak benar-benar dihapus dari database).
