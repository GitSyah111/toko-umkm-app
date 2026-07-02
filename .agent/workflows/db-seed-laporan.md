# Database Seed Laporan Workflow

## Objective
Menjalankan script SQL untuk menghitung dan mengisi tabel `toko_daily_summaries` dan `platform_daily_summaries` berdasarkan data transaksi dari tabel `orders` dan `order_items`.

## Steps for the Agent

1. **Kosongkan Tabel Summary (Optional/Opsional tapi Disarankan):**
   - Jalankan `php artisan tinker` dan eksekusi perintah truncate agar data lama tergantikan dengan perhitungan baru:
     ```bash
     php artisan tinker --execute="DB::statement('TRUNCATE TABLE toko_daily_summaries'); DB::statement('TRUNCATE TABLE platform_daily_summaries');"
     ```

2. **Jalankan Query Seeding Toko Daily Summaries:**
   - Jalankan perintah berikut menggunakan `php artisan tinker`:
     ```bash
     php artisan tinker --execute="DB::statement(\"INSERT INTO toko_daily_summaries (toko_id, tanggal, total_revenue, total_orders, created_at, updated_at) SELECT o.toko_id, DATE(o.tanggal_order) as tanggal, SUM(oi.subtotal) as total_revenue, COUNT(DISTINCT o.id) as total_orders, NOW(), NOW() FROM orders o JOIN order_items oi ON o.id = oi.order_id WHERE o.deleted_at IS NULL AND o.status != 'cancelled' GROUP BY o.toko_id, DATE(o.tanggal_order)\");"
     ```

3. **Jalankan Query Seeding Platform Daily Summaries:**
   - Jalankan perintah berikut menggunakan `php artisan tinker`:
     ```bash
     php artisan tinker --execute="DB::statement(\"INSERT INTO platform_daily_summaries (tanggal, total_gmv, total_orders, total_active_tokos, created_at, updated_at) SELECT DATE(o.tanggal_order) as tanggal, SUM(oi.subtotal) as total_gmv, COUNT(DISTINCT o.id) as total_orders, COUNT(DISTINCT o.toko_id) as total_active_tokos, NOW(), NOW() FROM orders o JOIN order_items oi ON o.id = oi.order_id WHERE o.deleted_at IS NULL AND o.status != 'cancelled' GROUP BY DATE(o.tanggal_order)\");"
     ```

4. **Verifikasi Data:**
   - Pastikan data berhasil masuk dengan memeriksa jumlah baris di tabel tersebut:
     ```bash
     php artisan tinker --execute="echo 'toko_daily_summaries: ' . DB::table('toko_daily_summaries')->count() . '\n'; echo 'platform_daily_summaries: ' . DB::table('platform_daily_summaries')->count() . '\n';"
     ```
   - Laporkan hasil verifikasi (jumlah data/record) kepada user.
