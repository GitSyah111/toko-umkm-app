# Analisis Kebutuhan Laporan & Optimasi Query

Berdasarkan *Use Case Diagram* pada aplikasi E-Commerce UMKM, terdapat beberapa fitur yang membutuhkan pengolahan data analitik dan reporting yang kompleks:
1. **Melihat Dashboard Analitik Toko** (Penjual)
2. **Mengunduh Laporan Keuangan** (Penjual)
3. **Melihat Laporan Kinerja Platform (GMV)** (Admin)

Dokumen ini merinci kebutuhan query untuk fitur-fitur tersebut dan solusi optimasi pada database (Tabel Summary & Index).

---

## 1. Dashboard Analitik Toko & Laporan Keuangan (Penjual)

**Metrik yang dibutuhkan:**
- **Total Revenue (Pendapatan):** Total nominal dari pesanan yang berstatus selesai/terkirim dalam periode waktu tertentu (harian/bulanan).
- **Total Order:** Jumlah transaksi pesanan yang masuk/berhasil.
- **Produk Terlaris:** Produk dengan jumlah *quantity* terbanyak yang dibeli.

**Analisis Query & Bottleneck:**
- Untuk menghitung *revenue* dan total *order*, sistem harus melakukan aggregate (SUM/COUNT) pada tabel `orders` difilter dengan `toko_id` dan *range* `tanggal_order`.
- *Bottleneck:* Seiring bertambahnya pesanan, melakukan SUM harian di tabel `orders` yang ukurannya membesar secara eksponensial akan sangat lambat. Begitu juga pencarian berdasarkan rentang waktu.

**Solusi & Kebutuhan Index/Tabel:**
- **Index:** `orders(toko_id, tanggal_order, status)` - Sangat penting agar filter pesanan toko pada waktu tertentu dengan status "Selesai" bisa dilakukan dengan cepat.
- **Summary Table:** `toko_daily_summaries`
  - Menyimpan agregasi harian (*revenue*, jumlah order) per `toko_id`.
  - Cronjob/Scheduler (atau *Observer* saat order selesai) akan mengupdate nilai di tabel ini setiap harinya.
  - Query ke Dashboard akan jauh lebih cepat karena hanya mengambil data dari tabel rekap ini, bukan tabel transaksi mentah.

---

## 2. Laporan Kinerja Platform / GMV (Admin)

**Metrik yang dibutuhkan:**
- **Gross Merchandise Value (GMV):** Total nilai transaksi di seluruh platform.
- **Total Transaksi:** Jumlah keseluruhan order di platform.
- **Jumlah Toko Aktif:** Jumlah toko yang menerima minimal satu order.

**Analisis Query & Bottleneck:**
- Sama seperti Dashboard Toko, namun dalam skala platform (tanpa filter `toko_id`). Menggunakan `SELECT SUM(total_bayar) FROM orders` secara real-time pada jutaan baris data akan menyebabkan *slow query*.

**Solusi & Kebutuhan Index/Tabel:**
- **Index:** `orders(tanggal_order, status)` - Untuk analitik platform.
- **Summary Table:** `platform_daily_summaries`
  - Menyimpan rekapitulasi harian platform (*total_gmv*, *total_orders*, *total_active_tokos*).
  - Digunakan langsung pada Dashboard Admin untuk load data grafik harian dengan sangat ringan.
