---
name: Run Scheduler Workflow
description: Workflow untuk menjalankan scheduler Laravel secara manual untuk pengujian.
---

# Workflow: Run Scheduler

Workflow ini digunakan untuk menguji task scheduler Laravel (seperti rekap data laporan) secara manual tanpa harus menunggu cron job berjalan sesuai jadwal.

## Langkah 1: Jalankan Command secara Langsung

Untuk memaksa spesifik task/command berjalan tanpa menunggu jadwal, kita bisa langsung memanggil command-nya melalui terminal:
```bash
php artisan summary
```
*(Anda juga bisa menambahkan opsi `--date="2023-10-01"` jika command mendukung parameter tanggal).*

## Langkah 2: Uji Konfigurasi Scheduler

Jika ingin menguji apakah konfigurasi di `app/Console/Kernel.php` sudah benar, Anda bisa menjalankan:
```bash
php artisan schedule:run
```
*(Catatan: ini hanya akan mengeksekusi command yang jadwal cron-nya cocok dengan waktu sistem saat ini).*

Untuk pengembangan lokal, Laravel menyediakan worker scheduler yang berjalan terus-menerus setiap menit:
```bash
php artisan schedule:work
```

## Langkah 3: Verifikasi Data Hasil Scheduler

Setelah command dijalankan, pastikan data yang dihasilkan tersimpan ke database.
Misalnya, untuk command `summary`:
1. Buka database atau jalankan `php artisan tinker`.
2. Periksa tabel `toko_daily_summaries`:
   ```php
   App\Models\TokoDailySummary::latest()->first();
   ```
3. Periksa tabel `platform_daily_summaries`:
   ```php
   App\Models\PlatformDailySummary::latest()->first();
   ```
4. Pastikan `total_revenue`, `total_gmv`, `total_hpp`, dan `total_orders` memiliki kalkulasi yang akurat berdasarkan data order dengan status `selesai`.
