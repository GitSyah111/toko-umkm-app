# Deskripsi Sistem: TokoKita

## 1. Pendahuluan
**TokoKita** adalah platform aplikasi web e-commerce yang dirancang khusus untuk mendukung Usaha Mikro, Kecil, dan Menengah (UMKM). Aplikasi ini memfasilitasi pemilik usaha untuk membuka toko online, memasarkan produk mereka, dan mengelola operasional bisnis secara efisien. Bagi masyarakat umum, platform ini memberikan kemudahan untuk mencari dan membeli produk-produk lokal dari berbagai UMKM secara aman dan nyaman.

## 2. Aktor Pengguna (User Roles)
Sistem ini melibatkan tiga jenis entitas pengguna utama:
1. **Pembeli (Customer)**: Pengguna umum yang menelusuri katalog, mencari, dan melakukan pembelian produk.
2. **Penjual (Pemilik Toko / UMKM)**: Pengguna yang telah mendaftarkan usahanya untuk berjualan, mengelola produk, dan memproses pesanan di platform.
3. **Admin Sistem (Super Admin)**: Pengelola platform yang memantau, memverifikasi, dan mengatur keseluruhan operasional sistem.

## 3. Kebutuhan Fungsional (Functional Requirements)

### 3.1. Fitur untuk Pembeli (Customer)
* **Manajemen Akun:** Registrasi, login, lupa password, dan pengelolaan profil (termasuk alamat pengiriman).
* **Eksplorasi Produk:** Mencari produk melalui kolom pencarian, memfilter berdasarkan kategori, harga, atau lokasi toko.
* **Keranjang Belanja (Cart):** Menambahkan produk ke keranjang, mengubah kuantitas, dan melihat estimasi total harga.
* **Checkout & Pembayaran:** Proses pembuatan pesanan (order) dan pemilihan metode pembayaran.
* **Manajemen Pesanan:** Melihat riwayat transaksi (pending, diproses, dikirim, selesai) dan mengonfirmasi penerimaan barang.
* **Ulasan & Penilaian (Rating):** Memberikan ulasan dan rating bintang pada produk setelah transaksi selesai.

### 3.2. Fitur untuk Penjual (Pemilik Toko)
* **Pendaftaran & Profil Toko:** Membuka toko baru dengan melengkapi informasi profil (nama toko, deskripsi, alamat, kontak, logo).
* **Manajemen Katalog Produk:**
  * Menambahkan produk baru lengkap dengan informasi (nama, deskripsi, harga, jumlah stok, berat, kategori, foto produk).
  * Mengedit informasi produk dan memperbarui stok.
  * Menghapus atau menonaktifkan produk (soft delete/status arsip).
* **Manajemen Pesanan (Order Management):**
  * Menerima notifikasi pesanan baru.
  * Mengubah status pesanan (contoh: Menunggu Pembayaran, Diproses, Dikirim, Selesai, Dibatalkan).
  * Menginput nomor resi pengiriman untuk dilacak oleh pembeli.
* **Laporan Kinerja Bisnis:**
  * Menampilkan ringkasan dan grafik penjualan (harian/mingguan/bulanan).
  * Menampilkan informasi produk terlaris (best sellers).
  * Laporan pendapatan kotor dan bersih.

### 3.3. Fitur untuk Admin Sistem
* **Dashboard Analytics:** Ringkasan statistik global platform (total pengguna, total toko aktif, total transaksi, total pendapatan).
* **Manajemen Pengguna & Toko:** Melihat daftar pengguna, menyetujui (verify) pendaftaran toko baru, atau memblokir akun/toko yang melanggar ketentuan.
* **Manajemen Kategori:** Menambah, mengubah, atau menghapus kategori produk utama yang akan digunakan oleh penjual.

## 4. Kebutuhan Non-Fungsional (Non-Functional Requirements)
* **Keamanan (Security):** 
  * Implementasi autentikasi dan otorisasi yang ketat.
  * Proteksi terhadap kerentanan web standar (CSRF, XSS, SQL Injection).
  * Enkripsi kata sandi menggunakan algoritma hashing modern.
* **Antarmuka Pengguna (UI/UX):** 
  * Desain harus responsif (berjalan optimal di desktop, tablet, dan smartphone). Mengingat UMKM sering menggunakan ponsel untuk mengelola bisnisnya.
  * Antarmuka yang intuitif dan mudah dipahami oleh kalangan umum.
* **Performa (Performance):** 
  * Sistem harus responsif dengan waktu pemuatan halaman yang cepat.
  * Mampu menangani banyak pengguna bersamaan (concurrent users) tanpa penurunan kinerja yang signifikan.

## 5. Spesifikasi Teknologi
* **Backend:** PHP (>= 8.1) dengan Framework Laravel 10.
* **Database:** MySQL / MariaDB.
* **Frontend:** Blade Templating Engine, CSS Framework (seperti Bootstrap atau Tailwind CSS), dan JavaScript (Vanilla / Alpine.js).
* **Arsitektur Sistem:** Monolith MVC (Model-View-Controller) untuk kemudahan pemeliharaan dan deployment di fase awal.
