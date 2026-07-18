---
name: Laravel Playwright E2E Testing
description: Memandu penulisan test end-to-end Playwright untuk proyek TokoKita menggunakan konvensi folder tests/e2e, fixture, helper database, dan Page Object Model.
---

# Panduan E2E Testing dengan Playwright (TokoKita)

Skill ini mendefinisikan konvensi dan struktur untuk penulisan tes end-to-end menggunakan  di proyek TokoKita.

## 1. Struktur Folder

Semua tes E2E Playwright dan file pendukungnya harus ditempatkan di dalam folder `tests/e2e/`.

```text
tests/e2e/
├── fixtures/          # Setup fixture Playwright (misal: auth state per role)
├── helpers/           # Fungsi utilitas/helper (misal: ambil akun dari DB)
├── pages/             # Page Object Model (POM) untuk interaksi UI
└── specs/             # File spesifikasi test per modul
```

## 2. Konvensi Penamaan File

*   Semua file tes E2E harus memiliki akhiran/ekstensi `.spec.ts` (contoh: `checkout.spec.ts`).
*   Kelompokkan file spesifikasi di dalam direktori `tests/e2e/specs/` berdasarkan modul aplikasi (contoh: `tests/e2e/specs/products/`, `tests/e2e/specs/orders/`, `tests/e2e/specs/auth/`).

## 3. Fixture untuk Login per Role

Gunakan *custom fixtures* dari Playwright untuk menyederhanakan proses autentikasi (login) dalam pengujian.
*   Buat fixture khusus untuk setiap *role* pengguna utama: `sellerPage`, `buyerPage`, dan `adminPage`.
*   Fixture ini secara otomatis mengatur state login (misalnya melalui cookies/storage state atau flow login UI yang diabstraksi) sebelum tes dijalankan.
*   Letakkan konfigurasi fixture ini di dalam `tests/e2e/fixtures/`.

## 4. Helper Pengambilan Akun Seeder dari Database

Hindari melakukan hardcode data kredensial di dalam test specs secara berlebihan.
*   Buat fungsi helper (contoh: di `tests/e2e/helpers/user.ts` atau `tests/e2e/helpers/db.ts`) yang dapat membaca atau menyiapkan akun pengguna dari *database seeder*.
*   Fungsi helper ini akan digunakan oleh fixture atau langsung di dalam spesifikasi pengujian untuk menjamin konsistensi data kredensial (terutama email/username akun seeder).

## 5. Page Object Model (POM)

Untuk halaman-halaman utama yang berulangkali dikunjungi dan diuji interaksinya, wajib menggunakan *Page Object Pattern*.
*   Halaman yang *wajib* menggunakan Page Object antara lain:
    *   **Halaman Login** (`tests/e2e/pages/LoginPage.ts`)
    *   **Halaman Dashboard** (`tests/e2e/pages/DashboardPage.ts`)
*   Setiap kelas Page Object merangkum *locators* (elemen pada halaman) dan *actions* (aksi yang dilakukan seperti `login(user, pass)` atau `navigateToProfile()`), sehingga kode pengujian lebih bersih dan mudah dikelola bila ada perubahan struktur UI/DOM.

## 6. Perintah Eksekusi Test Playwright

Berikut adalah beberapa perintah yang sering digunakan untuk menjalankan tes Playwright:

*   **Jalankan seluruh test e2e:**
    ```bash
    npx playwright test
    ```
*   **Jalankan satu file saja:**
    ```bash
    npx playwright test produk.spec.ts
    ```
*   **Jalankan dengan tampilan browser terlihat (untuk debugging visual):**
    ```bash
    npx playwright test --headed
    ```
*   **Jalankan satu test spesifik dalam mode debug interaktif:**
    ```bash
    npx playwright test --debug
    ```
*   **Buka laporan HTML setelah eksekusi selesai:**
    ```bash
    npx playwright show-report docs/testing/playwright-report
    ```
*   **Buka trace viewer untuk satu test yang gagal:**
    ```bash
    npx playwright show-trace test-results/produk-edit/trace.zip
    ```
