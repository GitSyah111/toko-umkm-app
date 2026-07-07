---
name: Laravel Setup
description: Memandu instalasi proyek Laravel 10 untuk TokoKita, termasuk persyaratan PHP, konfigurasi database, dan setup autentikasi menggunakan Laravel Breeze (Blade + Tailwind CSS).
---

# Panduan Setup Laravel 10 untuk TokoKita

Skill ini berisi panduan untuk menginstal dan mengkonfigurasi proyek Laravel 10 untuk aplikasi TokoKita.

## 1. Persyaratan Sistem

-   **PHP Minimum:** Versi PHP 8.1 (Wajib untuk Laravel 10).
-   **Composer:** Pastikan Composer sudah terinstal dengan benar.
-   **Node.js & NPM:** Dibutuhkan untuk kompilasi aset frontend.

## 2. Instalasi Proyek Laravel

Untuk membuat proyek Laravel 10 baru, jalankan perintah berikut di terminal:

```bash
composer create-project laravel/laravel:^10.0 tokokita
```

Atau jika Anda sudah berada di dalam direktori `toko-umkm-app`, jalankan penyesuaian dependensi Laravel 10:

```bash
composer require laravel/framework:^10.0
```

## 3. Konfigurasi Database (`.env`)

Buka file `.env` di root proyek Anda, dan sesuaikan bagian koneksi database untuk menggunakan database `tokokita`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tokokita
DB_USERNAME=root   # Sesuaikan dengan username DB Anda
DB_PASSWORD=       # Sesuaikan dengan password DB Anda
```

> Jangan lupa untuk membuat database `tokokita` di MySQL/MariaDB (misalnya melalui HeidiSQL atau phpMyAdmin) sebelum menjalankan migrasi.

## 4. Setup Autentikasi (Laravel Breeze + Blade + Tailwind CSS)

TokoKita menggunakan Laravel Breeze dengan stack **Blade** dan **Tailwind CSS** untuk scaffolding autentikasi dasar (Login, Register, Reset Password, dll).

Lakukan langkah-langkah berikut secara berurutan:

1.  **Instal package Laravel Breeze (Dev Dependency):**
    ```bash
    composer require laravel/breeze --dev
    ```

2.  **Jalankan proses instalasi Breeze dengan stack Blade:**
    ```bash
    php artisan breeze:install blade
    ```

3.  **Instal dependensi frontend (termasuk Tailwind CSS) dan compile:**
    ```bash
    npm install
    npm run build
    ```

4.  **Jalankan migrasi database:**
    Perintah ini akan membuat tabel-tabel bawaan (users, password_resets, dll) di database `tokokita`.
    ```bash
    php artisan migrate
    ```

## 5. Verifikasi

Setelah semua langkah selesai, jalankan server pengembangan:

```bash
php artisan serve
```

Akses `http://localhost:8000` (atau via host virtual Laragon Anda seperti `http://toko-umkm-app.test`). Anda seharusnya melihat halaman welcome Laravel 10 dengan link "Log in" dan "Register" di pojok kanan atas yang sudah tertata dengan Tailwind CSS.
