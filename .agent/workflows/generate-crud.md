---
name: Generate CRUD Workflow
description: Workflow untuk menghasilkan Migration, Model, Controller, Form Request, Route, dan View CRUD untuk entitas baru.
---

# Workflow: Generate CRUD

Workflow ini memandu AI agent untuk menerima nama entitas sebagai input dan secara otomatis membuat semua komponen CRUD (Migration, Model, Controller, Form Request, Route, dan View) agar selaras dan konsisten dengan komponen yang sudah ada di proyek Toko UMKM ini.

## Langkah 1: Analisis Kebutuhan
1. Pastikan nama entitas yang diminta oleh user (contoh: `Kategori`, `Kupon`).
2. Tentukan field apa saja yang dibutuhkan pada database berdasarkan deskripsi entitas tersebut.
3. Tentukan scope / role (misal: admin, seller, atau buyer) untuk menentukan letak namespace, route, dan view.

## Langkah 2: Buat Komponen Backend (Artisan Commands)
Gunakan tool terminal untuk menjalankan perintah berikut (atau buat file secara manual jika perintah artisan tidak tersedia untuk komponen tersebut):
1. **Migration & Model**: `php artisan make:model NamaEntitas -m`
2. **Requests**: 
   - `php artisan make:request StoreNamaEntitasRequest`
   - `php artisan make:request UpdateNamaEntitasRequest`
3. **Controller**: `php artisan make:controller NamaEntitasController --resource`
4. **Service**: Buat file `app/Services/NamaEntitasService.php` secara manual. Service class ini bertugas menangani logika bisnis yang kompleks agar Controller tetap bersih.
5. **Observer (Opsional)**: Jika entitas membutuhkan efek samping saat *create*, *update*, atau *delete* (contoh: otomatis memotong stok saat order dibuat), jalankan `php artisan make:observer NamaEntitasObserver --model=NamaEntitas` dan daftarkan di `EventServiceProvider.php`.

## Langkah 3: Modifikasi Model
Buka file Model (`app/Models/NamaEntitas.php`) dan pastikan:
- Menggunakan trait `HasFactory` dan `SoftDeletes`.
- Menambahkan property `protected $fillable = [...];` sesuai dengan kolom tabel.
- Mendefinisikan relasi (seperti `belongsTo` atau `hasMany`) jika entitas berhubungan dengan tabel lain.

## Langkah 4: Modifikasi Migration
Buka file Migration yang baru dibuat (`database/migrations/YYYY_MM_DD_HHMMSS_create_nama_entitas_table.php`) dan pastikan:
- Mendefinisikan kolom sesuai kebutuhan.
- Menambahkan `$table->softDeletes();` pada schema untuk mendukung soft delete.
- *Lakukan migrasi database dengan `php artisan migrate` jika diizinkan oleh user.*

## Langkah 5: Modifikasi Form Requests
Buka `StoreNamaEntitasRequest` dan `UpdateNamaEntitasRequest`:
- Ubah return pada method `authorize()` menjadi `return true;` (atau atur otorisasi khusus jika dibutuhkan).
- Daftarkan validasi pada method `rules()`.

## Langkah 6: Modifikasi Controller
Buka `NamaEntitasController` dan gunakan Eloquent untuk membaca data (Read), sedangkan untuk operasi simpan, ubah, dan hapus (Write), delegasikan ke `NamaEntitasService` melalui injeksi (*Dependency Injection*). Pastikan struktur method konsisten:
- **`index()`**: Ambil data (contoh `NamaEntitas::paginate(10);`) dan passing ke view `index`.
- **`create()`**: Return view `create`.
- **`store()`**: Injeksi `NamaEntitasService`, gunakan `StoreNamaEntitasRequest`, delegasikan penyimpanan data ke Service, redirect ke `index` dengan pesan sukses.
- **`show()`**: Gunakan route model binding, return view `show`.
- **`edit()`**: Return view `edit`.
- **`update()`**: Injeksi `NamaEntitasService`, gunakan `UpdateNamaEntitasRequest`, delegasikan pembaruan data ke Service, redirect ke `index` dengan pesan sukses.
- **`destroy()`**: Injeksi `NamaEntitasService`, delegasikan penghapusan data ke Service, redirect ke `index` dengan pesan sukses.

*Catatan: Pastikan otorisasi (jika ada peran/toko tertentu) diterapkan pada setiap method, serupa dengan `ProdukController`. Controller hanya bertugas menangani HTTP Request/Response, validasi (melalui Form Request), dan delegasi ke Service.*

## Langkah 7: Modifikasi Route
Buka file route terkait (contoh: `routes/web.php`):
- Tambahkan resource route: `Route::resource('url-entitas', NamaEntitasController::class);`.
- Pastikan diletakkan di dalam block auth/middleware atau prefix yang sesuai (misal: `prefix('seller')`).

## Langkah 8: Pembuatan View (Blade)
Buat direktori `resources/views/role/nama-entitas/` dan hasilkan 4 file menggunakan konvensi Tailwind CSS dan layout aplikasi:
1. **`index.blade.php`**: Tabel untuk menampilkan daftar data, lengkap dengan tombol navigasi, status badge, dan pagination `{{ $data->links() }}`.
2. **`create.blade.php`**: Form pembuatan data dengan `@csrf`, input, dan penanganan error (`@error`).
3. **`edit.blade.php`**: Form pembaruan data dengan `@csrf`, `@method('PUT')`, field dengan value default data terkait.
4. **`show.blade.php`**: Tampilan detail entitas (readonly) dengan tombol kembali.

*Gunakan struktur blade `<x-app-layout>` (atau layout dashboard yang relevan).*

## Langkah 9: Verifikasi
- Tinjau kembali seluruh file yang diubah dan pastikan syntax benar.
- Jika perlu, tampilkan pesan ke user dan tanyakan apakah ada komponen tambahan yang perlu dimodifikasi.

## Langkah 10: Pengujian End-to-End (E2E)
- Buat file test Playwright baru di `tests/e2e/specs/` untuk entitas ini.
- Gunakan fixture autentikasi (`sellerPage`, `buyerPage`, atau `adminPage`) sesuai dengan role entitas.
- Uji minimal skenario 'lihat daftar', 'tambah data', dan 'ubah data'.
