# Scope Aplikasi: Batasan Sistem untuk Skripsi (1 Semester)

Berdasarkan deskripsi sistem secara keseluruhan pada dokumen sebelumnya, berikut adalah batasan ruang lingkup (scope) yang realistis untuk dikerjakan dalam waktu 1 semester. Fokus pengembangan ditekankan pada modul operasional yang kompleks dan penyediaan laporan analitik komprehensif bagi penjual (UMKM) maupun admin.

## 1. Batasan Fitur dan Fungsionalitas (In-Scope)

### 1.1. Modul Inti (Core)
* **Autentikasi Multi-Role:** Implementasi login, registrasi, dan manajemen session untuk 3 peran: Admin, Penjual, dan Pembeli.
* **Manajemen Toko & Produk:** 
  * Penjual dapat membuat dan mengelola satu toko.
  * Manajemen produk mencakup atribut dasar: Nama, Deskripsi, Kategori, Harga Pokok/Modal, Harga Jual, Stok, Berat, dan Foto Utama.
* **Keranjang Belanja & Checkout:** Pembeli dapat membeli produk dari satu toko dalam satu transaksi, atau sistem memecah sub-order jika membeli dari banyak toko (opsi yang disederhanakan).
* **Manajemen Pesanan Terintegrasi:** Alur status pesanan (Menunggu Pembayaran -> Diproses -> Dikirim -> Selesai -> Dibatalkan).
* **Pembayaran:** Simulasi pembayaran manual (upload bukti transfer yang harus diverifikasi) atau menggunakan integrasi *payment gateway* dasar (contoh: Midtrans) secara *sandbox*.
* **Manajemen Stok Otomatis:** Stok berkurang secara otomatis ketika pesanan berhasil dibayar, dan dikembalikan jika pesanan dibatalkan.

### 1.2. Fitur yang Dikecualikan (Out-of-Scope)
Untuk menjaga agar fokus skripsi tidak melebar, fitur-fitur berikut **tidak** diwajibkan:
* Integrasi cek ongkir (kurir ekspedisi) secara *real-time* lewat API. Dapat disimulasikan statis dengan ongkir *flat-rate* atau *rate table* per kota untuk menyederhanakan.
* Fitur *Live Chat* antar pengguna.
* Sistem *Affiliate*, Diskon/Voucher *Flash Sale* yang sangat rumit (cukup diskon nominal/persentase sederhana pada produk jika diperlukan).

---

## 2. Kompleksitas Pengelolaan Data

Sebagai sistem untuk skripsi, aplikasi ini dituntut untuk memiliki kedalaman dalam pengolahan data:
* **Relasi Database Kompleks:** Tabel yang saling berelasi kuat (User, Toko, Produk, Kategori, Pesanan, Detail Pesanan, Pembayaran).
* **Perhitungan Laba/Rugi Otomatis:** Sistem mencatat HPP (Harga Pokok Penjualan) saat pesanan terjadi, sehingga penjual bisa melihat margin keuntungannya, tidak hanya omset kotor.
* **Penggunaan Eloquent yang Kompleks:** Aggregasi data menggunakan *Query Builder* / *Eloquent ORM* tingkat lanjut untuk menghasilkan laporan analitik.

---

## 3. Modul Pelaporan (Reporting & Analytics)

Modul pelaporan akan menjadi salah satu nilai tambah utama (bobot penilaian tinggi). Sistem harus mampu menyajikan minimal 10 jenis laporan dengan format keluaran yang beragam: **Cetak Langsung/PDF, Ekspor Excel (CSV/XLSX), Grafik (Charts), dan Visual Dashboard**.

Berikut 10 jenis laporan yang disepakati untuk skripsi ini:

### Dokumen Operasional Eksekusi (Cetak/PDF)
1. **Invoice / Bukti Pembayaran Pemesanan (PDF):** Dokumen rincian tagihan pesanan yang dapat dicetak oleh pembeli sebagai bukti atau oleh penjual sebagai arsip.
2. **Cetak Label Pengiriman / Packing List (PDF):** Format siap cetak (*print-ready*) yang mencantumkan nama, alamat, nomor HP pembeli, toko pengirim, serta daftar barang untuk ditempel di paket pesanan.

### Laporan Keuangan dan Penjualan (Tabel, Excel, PDF)
3. **Laporan Rekapitulasi Penjualan (Excel & PDF):** Menyajikan total transaksi dan omset (pendapatan kotor) dalam rentang waktu tertentu (harian, mingguan, bulanan) yang dipilih oleh penjual.
4. **Laporan Laba Bersih Toko (Excel & PDF):** Laporan analisis margin keuntungan yang menghitung selisih antara Total Penjualan dengan Harga Modal (HPP) barang yang terjual per periode.
5. **Laporan Transaksi Dibatalkan/Gagal (Excel):** Rincian pesanan yang dibatalkan oleh pembeli atau penjual guna mengevaluasi penyebab kegagalan transaksi.

### Laporan Performa Toko (Visual Dashboard & Chart)
6. **Grafik Pertumbuhan Penjualan (Line Chart):** Visualisasi interaktif di dashboard penjual untuk memantau naik-turunnya omset penjualan dari bulan ke bulan.
7. **Laporan Produk Terlaris / Best Seller (Pie/Doughnut Chart):** Persentase atau ranking dari 5-10 produk dengan kuantitas paling sering dibeli, untuk membantu strategi *restock*.
8. **Statistik Status Pesanan (Bar/Donut Chart):** Perbandingan komposisi pesanan masuk (Selesai vs Diproses vs Dibatalkan) dalam satu bulan terakhir.
9. **Peringatan Stok Menipis (Dashboard Alert & Excel):** Daftar otomatis pada dashboard penjual menampilkan produk yang sisa stoknya mencapai batas minimum (misal: sisa < 5), dapat diunduh (Excel) sebagai *checklist* kulakan/stok opname.

### Laporan Level Admin Sistem
10. **Laporan Tren Kinerja Platform Keseluruhan (Grafik Garis & Excel):** Laporan *Gross Merchandise Value (GMV)* yang merangkum total volume transaksi dari seluruh toko di platform, serta grafik pertumbuhan jumlah pendaftaran toko baru, digunakan oleh superadmin.
