# Kumpulan Diagram UML - Toko UMKM App

Direktori ini berisi diagram-diagram UML (Unified Modeling Language) yang mendefinisikan rancangan sistem untuk aplikasi E-Commerce UMKM. Semua diagram ditulis dalam format PlantUML (`.puml`).

## Daftar Diagram

### 1. Use Case Diagram
- **File**: [`use-case.puml`](./use-case.puml)
- **Deskripsi**: Menggambarkan interaksi tingkat tinggi antara aktor (Pembeli, Penjual, Admin) dengan sistem secara keseluruhan. Memetakan fungsionalitas apa saja yang dapat dilakukan oleh masing-masing aktor.

### 2. Activity Diagram
Berikut adalah turunan Activity Diagram untuk setiap *use case* yang telah didefinisikan:

| No | Nama Use Case | File Diagram | Deskripsi |
|---|---|---|---|
| 1 | Login | [`activity-login.puml`](./activity-login.puml) | Alur pengguna saat masuk ke dalam sistem menggunakan kredensial (email & password). |
| 2 | Registrasi | [`activity-register.puml`](./activity-register.puml) | Alur pengguna baru untuk mendaftar sebagai Pembeli atau Penjual. |
| 3 | Membuat & Mengelola Toko | [`activity-toko.puml`](./activity-toko.puml) | Alur bagi Penjual untuk membuat profil toko baru atau mengubah informasi toko yang sudah ada. |
| 4 | Mengelola Produk (CRUD) | [`activity-produk.puml`](./activity-produk.puml) | Alur bagi Penjual dalam menambah, mengubah, dan menghapus data produk. |
| 5 | Mencari & Melihat Produk | [`activity-viewprod.puml`](./activity-viewprod.puml) | Alur Pembeli dalam mencari barang, memfilter, dan melihat detail spesifik dari sebuah produk. |
| 6 | Mengelola Keranjang Belanja | [`activity-cart.puml`](./activity-cart.puml) | Alur Pembeli menambahkan produk ke keranjang, merubah kuantitas, atau menghapus item sebelum checkout. |
| 7 | Melakukan Checkout | [`activity-checkout.puml`](./activity-checkout.puml) | Alur Pembeli memproses keranjang, memilih alamat, ekspedisi pengiriman, dan metode pembayaran. |
| 8 | Melakukan Pembayaran | [`activity-pay.puml`](./activity-pay.puml) | Alur interaksi pembayaran melalui Payment Gateway hingga status pesanan terupdate. |
| 9 | Memproses Pesanan | [`activity-processorder.puml`](./activity-processorder.puml) | Alur Penjual dalam menerima atau menolak pesanan, hingga memasukkan resi pengiriman. |
| 10 | Membatalkan Pesanan | [`activity-cancelorder.puml`](./activity-cancelorder.puml) | Alur pembatalan pesanan baik oleh sistem, pembeli, maupun penjual sebelum pesanan dikirim. |
| 11 | Mencetak Invoice | [`activity-invoice.puml`](./activity-invoice.puml) | Alur mengunduh atau mencetak dokumen rincian transaksi (invoice). |
| 12 | Mencetak Label Pengiriman | [`activity-label.puml`](./activity-label.puml) | Alur Penjual mencetak label berisi detail alamat untuk ditempel di paket kiriman. |
| 13 | Melihat Dashboard Toko | [`activity-sellerdash.puml`](./activity-sellerdash.puml) | Alur Penjual memantau ringkasan statistik dan performa toko mereka. |
| 14 | Mengunduh Laporan Keuangan | [`activity-reportkeuangan.puml`](./activity-reportkeuangan.puml) | Alur Penjual mengunduh rekap pendapatan dan transaksi dalam format Excel/PDF. |
| 15 | Melihat Laporan Platform (GMV) | [`activity-admindash.puml`](./activity-admindash.puml) | Alur Admin memantau kinerja keseluruhan platform e-commerce (GMV, Transaksi). |

### 3. Sequence Diagram
Berikut adalah turunan Sequence Diagram dari setiap Activity Diagram yang merepresentasikan interaksi komponen sistem dalam arsitektur MVC (Model-View-Controller) Laravel:

| No | Nama Proses | File Diagram |
|---|---|---|
| 1 | Login | [`sequence-login.puml`](./sequence-login.puml) |
| 2 | Registrasi | [`sequence-register.puml`](./sequence-register.puml) |
| 3 | Membuat & Mengelola Toko | [`sequence-toko.puml`](./sequence-toko.puml) |
| 4 | Mengelola Produk | [`sequence-produk.puml`](./sequence-produk.puml) |
| 5 | Mencari & Melihat Produk | [`sequence-viewprod.puml`](./sequence-viewprod.puml) |
| 6 | Mengelola Keranjang | [`sequence-cart.puml`](./sequence-cart.puml) |
| 7 | Melakukan Checkout | [`sequence-checkout.puml`](./sequence-checkout.puml) |
| 8 | Melakukan Pembayaran | [`sequence-pay.puml`](./sequence-pay.puml) |
| 9 | Memproses Pesanan | [`sequence-processorder.puml`](./sequence-processorder.puml) |
| 10 | Membatalkan Pesanan | [`sequence-cancelorder.puml`](./sequence-cancelorder.puml) |
| 11 | Mencetak Invoice | [`sequence-invoice.puml`](./sequence-invoice.puml) |
| 12 | Mencetak Label Pengiriman | [`sequence-label.puml`](./sequence-label.puml) |
| 13 | Melihat Dashboard Toko | [`sequence-sellerdash.puml`](./sequence-sellerdash.puml) |
| 14 | Mengunduh Laporan Keuangan | [`sequence-reportkeuangan.puml`](./sequence-reportkeuangan.puml) |
| 15 | Melihat Laporan Platform | [`sequence-admindash.puml`](./sequence-admindash.puml) |

---### 4. Class Diagram
- **File**: [`class-diagram.puml`](./class-diagram.puml)
- **Deskripsi**: Merupakan struktur statis dari sistem yang menggambarkan relasi antar entitas utama aplikasi (berdasarkan hasil sintesis dari use case, activity, dan sequence diagram). Entitas utama yang terlibat meliputi:
  - **User**: Entitas untuk menyimpan data pengguna dan menangani autentikasi.
  - **Toko**: Entitas untuk profil dan informasi toko milik Penjual.
  - **Produk**: Entitas untuk detail barang yang dijual, stok, dan harga.
  - **Cart & CartItem**: Entitas untuk menangani keranjang belanja pembeli.
  - **Order & OrderItem**: Entitas untuk merekam data transaksi pesanan, status, dan detail barang.
  - **Payment**: Entitas untuk mencatat transaksi pembayaran dan metode yang digunakan.


## Cara Render Diagram
Anda dapat menggunakan ekstensi IDE (seperti PlantUML di VSCode/JetBrains) atau menggunakan server publik PlantUML untuk me-render kode menjadi gambar (PNG/SVG).
