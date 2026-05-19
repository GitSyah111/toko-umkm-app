# Skema Database (ERD): TokoKita

Berdasarkan *scope* aplikasi yang telah ditentukan, berikut adalah rancangan skema database relasional (Entity-Relationship) yang akan digunakan. Rancangan ini mencakup tabel-tabel utama yang saling berelasi untuk mendukung pengelolaan yang kompleks dan pembuatan 10 jenis laporan.

## Daftar Tabel dan Atribut

### 1. Tabel `users` (Pengguna)
Menyimpan data otentikasi untuk semua jenis pengguna (Admin, Penjual, Pembeli).
* `id` (PK, BigInt)
* `name` (Varchar 255)
* `email` (Varchar 255, Unique)
* `password` (Varchar 255)
* `role` (Enum: 'admin', 'seller', 'buyer') - *Menentukan hak akses*
* `phone_number` (Varchar 20, Nullable)
* `address` (Text, Nullable)
* `created_at` & `updated_at` (Timestamp)

### 2. Tabel `stores` (Toko)
Menyimpan profil toko milik penjual (seller). Setiap penjual (user) hanya memiliki 1 toko (One-to-One).
* `id` (PK, BigInt)
* `user_id` (FK ke `users.id`, Unique)
* `name` (Varchar 255)
* `slug` (Varchar 255, Unique) - *Untuk URL toko*
* `description` (Text)
* `address` (Text)
* `logo` (Varchar 255, Nullable)
* `status` (Enum: 'active', 'inactive', 'banned') - *Bisa diatur oleh admin*
* `created_at` & `updated_at` (Timestamp)

### 3. Tabel `categories` (Kategori Produk)
Menyimpan master data kategori yang dibuat oleh Admin.
* `id` (PK, BigInt)
* `name` (Varchar 255)
* `slug` (Varchar 255, Unique)
* `created_at` & `updated_at` (Timestamp)

### 4. Tabel `products` (Produk)
Menyimpan data katalog produk. Setiap produk dimiliki oleh satu toko (One-to-Many).
* `id` (PK, BigInt)
* `store_id` (FK ke `stores.id`)
* `category_id` (FK ke `categories.id`)
* `name` (Varchar 255)
* `slug` (Varchar 255, Unique)
* `description` (Text)
* `base_price` (Decimal) - *Harga Pokok Penjualan (HPP) / Modal. Penting untuk laporan Laba/Rugi.*
* `price` (Decimal) - *Harga Jual ke konsumen.*
* `stock` (Integer) - *Akan berkurang otomatis jika ada pesanan valid.*
* `weight` (Integer) - *Dalam gram, untuk kalkulasi ongkos kirim (jika ada).*
* `image` (Varchar 255, Nullable) - *Foto utama produk.*
* `is_active` (Boolean, Default: true) - *Untuk soft-delete/arsip produk.*
* `created_at` & `updated_at` (Timestamp)

### 5. Tabel `orders` (Pesanan)
Mencatat *header* transaksi pemesanan. Relasi dari `users` (pembeli) ke `stores` (penjual).
* `id` (PK, BigInt)
* `order_number` (Varchar 50, Unique) - *Contoh: INV-20231015-001*
* `user_id` (FK ke `users.id`) - *Pembeli*
* `store_id` (FK ke `stores.id`) - *Toko penjual*
* `total_amount` (Decimal) - *Total harga barang + ongkir*
* `shipping_cost` (Decimal) - *Ongkos kirim statis*
* `shipping_address` (Text) - *Alamat pengiriman spesifik untuk pesanan ini*
* `status` (Enum: 'pending', 'processing', 'shipped', 'completed', 'cancelled')
* `cancel_reason` (Text, Nullable) - *Alasan jika dibatalkan (Untuk laporan pembatalan).*
* `receipt_number` (Varchar 100, Nullable) - *Nomor resi pengiriman.*
* `created_at` & `updated_at` (Timestamp)

### 6. Tabel `order_items` (Detail Pesanan)
Mencatat barang apa saja yang dibeli dalam satu nomor pesanan (Many-to-Many melalui tabel pivot ini).
* `id` (PK, BigInt)
* `order_id` (FK ke `orders.id`)
* `product_id` (FK ke `products.id`)
* `quantity` (Integer)
* `price` (Decimal) - *Harga jual saat transaksi terjadi (snapshot, agar tidak berubah jika harga master berubah).*
* `base_price` (Decimal) - *Harga modal saat transaksi terjadi (snapshot).*
* `subtotal` (Decimal) - *quantity x price*
* `created_at` & `updated_at` (Timestamp)

### 7. Tabel `payments` (Pembayaran)
Mencatat data konfirmasi pembayaran dari pembeli (Misal: upload bukti transfer).
* `id` (PK, BigInt)
* `order_id` (FK ke `orders.id`, Unique)
* `amount` (Decimal) - *Jumlah yang dibayar*
* `payment_method` (Varchar 100) - *Contoh: 'Transfer Bank BCA', 'Mandiri', dll.*
* `proof_image` (Varchar 255) - *URL/Path foto bukti transfer.*
* `status` (Enum: 'pending', 'verified', 'rejected')
* `created_at` & `updated_at` (Timestamp)

---

## Catatan Relasi untuk Pelaporan (Analytics)

Rancangan di atas telah dipersiapkan agar sangat efisien untuk menghasilkan **10 Laporan Skripsi** yang diminta:
1. **Laba/Rugi:** Bisa dihitung secara presisi karena setiap baris di `order_items` meng-capture `base_price` (modal) dan `price` (jual) secara mandiri saat *checkout*. Laba = `(price - base_price) * quantity`.
2. **Best Seller:** Melakukan aggregasi (`SUM(quantity)`) pada tabel `order_items` yang di-join dengan tabel `products` dengan syarat `orders.status = 'completed'`.
3. **Peringatan Stok:** Cukup melakukan query sederhana `SELECT * FROM products WHERE stock <= 5 AND store_id = X`.
4. **Grafik Pertumbuhan Pendapatan:** Menggunakan fungsi `SUM(total_amount)` di tabel `orders` dan di-grouping berdasarkan `MONTH(created_at)` atau `DATE(created_at)`.
