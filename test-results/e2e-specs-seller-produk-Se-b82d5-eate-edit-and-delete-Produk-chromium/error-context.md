# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: e2e\specs\seller\produk.spec.ts >> Seller Produk CRUD >> should be able to create, edit, and delete Produk
- Location: tests\e2e\specs\seller\produk.spec.ts:1:94

# Error details

```
Test timeout of 30000ms exceeded.
```

```
Error: locator.click: Test timeout of 30000ms exceeded.
Call log:
  - waiting for getByRole('button', { name: 'Simpan' })
    - locator resolved to <button type="submit" x-bind:disabled="!isFormValid" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50 disabled:cursor-not-allowed">Simpan</button>
  - attempting click action
    2 × waiting for element to be visible, enabled and stable
      - element is not enabled
    - retrying click action
    - waiting 20ms
    2 × waiting for element to be visible, enabled and stable
      - element is not enabled
    - retrying click action
      - waiting 100ms
    27 × waiting for element to be visible, enabled and stable
       - element is not enabled
     - retrying click action
       - waiting 500ms

```

# Page snapshot

```yaml
- generic [ref=e2]:
  - complementary [ref=e3]:
    - link "TokoKita" [ref=e5] [cursor=pointer]:
      - /url: http://127.0.0.1:8000/dashboard
    - navigation [ref=e7]:
      - link "Dashboard" [ref=e8] [cursor=pointer]:
        - /url: http://127.0.0.1:8000/dashboard
        - img [ref=e9]
        - generic [ref=e11]: Dashboard
      - separator [ref=e12]
      - generic [ref=e13]: Toko Saya
      - link "Profil Toko" [ref=e14] [cursor=pointer]:
        - /url: http://127.0.0.1:8000/seller/toko
        - img [ref=e15]
        - generic [ref=e17]: Profil Toko
      - link "Produk" [ref=e18] [cursor=pointer]:
        - /url: http://127.0.0.1:8000/seller/produk
        - img [ref=e19]
        - generic [ref=e22]: Produk
      - link "Pesanan Masuk" [ref=e23] [cursor=pointer]:
        - /url: http://127.0.0.1:8000/seller/orders
        - img [ref=e24]
        - generic [ref=e26]: Pesanan Masuk
  - generic [ref=e27]:
    - navigation [ref=e28]:
      - generic [ref=e30]:
        - generic [ref=e31]:
          - link "TokoKita" [ref=e33] [cursor=pointer]:
            - /url: http://127.0.0.1:8000/dashboard
          - link "Dashboard" [ref=e35] [cursor=pointer]:
            - /url: http://127.0.0.1:8000/dashboard
        - button "Budi Santoso" [ref=e39] [cursor=pointer]:
          - generic [ref=e40]: Budi Santoso
          - img [ref=e42]
    - banner [ref=e44]:
      - generic [ref=e45]: Tambah Produk Baru
    - main [ref=e46]:
      - generic [ref=e49]:
        - generic [ref=e50]:
          - generic [ref=e51]: Toko
          - combobox "Toko" [ref=e52]:
            - option "Pilih Toko"
            - option "Budi Jaya Elektronik" [selected]
        - generic [ref=e53]:
          - generic [ref=e54]: Nama Produk
          - textbox "Nama Produk" [ref=e55]
        - generic [ref=e56]:
          - generic [ref=e57]: Kategori
          - combobox "Kategori" [ref=e58]:
            - option "Pilih Kategori"
            - option "Elektronik" [selected]
            - option "Fashion"
            - option "Kuliner"
        - generic [ref=e59]:
          - generic [ref=e60]: Deskripsi
          - textbox "Deskripsi" [ref=e61]: Deskripsi produk testing
        - generic [ref=e62]:
          - generic [ref=e63]:
            - generic [ref=e64]: Harga Pokok (HPP) Rp
            - spinbutton "Harga Pokok (HPP) Rp" [ref=e65]: "10000"
          - generic [ref=e66]:
            - generic [ref=e67]: Harga Jual (Rp)
            - spinbutton "Harga Jual (Rp)" [ref=e68]
        - generic [ref=e69]:
          - generic [ref=e70]:
            - generic [ref=e71]: Stok
            - spinbutton "Stok" [ref=e72]
          - generic [ref=e73]:
            - generic [ref=e74]: Berat (gram)
            - spinbutton "Berat (gram)" [active] [ref=e75]: "1000"
        - generic [ref=e76]:
          - generic [ref=e77]: Status
          - combobox "Status" [ref=e78]:
            - option "Aktif" [selected]
            - option "Nonaktif"
        - generic [ref=e79]:
          - link "Batal" [ref=e80] [cursor=pointer]:
            - /url: http://127.0.0.1:8000/seller/produk
          - button "Simpan" [disabled] [ref=e81]
    - contentinfo [ref=e82]:
      - paragraph [ref=e84]: © 2026 TokoKita. Hak Cipta Dilindungi Undang-Undang.
```

# Test source

```ts
> 1  | import { test, expect } from '../../fixtures/auth.fixture';
     |                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      ^ Error: locator.click: Test timeout of 30000ms exceeded.
  2  | 
  3  | test.describe('Seller Produk CRUD', () => {
  4  |   test('should be able to create, edit, and delete Produk', async ({ sellerPage }) => {
  5  |     // 1. Navigate to Produk Index
  6  |     await sellerPage.goto('/seller/produk');
  7  |     await expect(sellerPage.getByRole('heading', { name: 'Daftar Produk' })).toBeVisible();
  8  | 
  9  |     // 2. Create Produk
  10 |     await sellerPage.getByRole('link', { name: 'Tambah Produk' }).click();
  11 |     await expect(sellerPage.getByText('Tambah Produk Baru', { exact: false })).toBeVisible();
  12 | 
  13 |     // Fill form
  14 |     // Select first toko
  15 |     await sellerPage.getByLabel('Toko').selectOption({ index: 1 });
  16 |     await sellerPage.getByLabel('Nama Produk').fill('Produk E2E Playwright');
  17 |     await sellerPage.getByLabel('Kategori').selectOption({ index: 1 });
  18 |     await sellerPage.getByLabel('Deskripsi').fill('Deskripsi produk testing');
  19 |     await sellerPage.getByLabel('Harga Pokok (HPP) Rp').fill('10000');
  20 |     await sellerPage.getByLabel('Harga Jual (Rp)').fill('15000');
  21 |     await sellerPage.getByLabel('Stok').fill('10');
  22 |     await sellerPage.getByLabel('Berat (gram)').fill('1000');
  23 |     await sellerPage.getByLabel('Status').selectOption('aktif');
  24 |     
  25 |     await sellerPage.getByRole('button', { name: 'Simpan' }).click();
  26 |     
  27 |     await sellerPage.waitForLoadState('networkidle');
  28 |     const pageText = await sellerPage.innerText('body');
  29 |     console.log('PRODUK PAGE TEXT AFTER CREATE:', pageText);
  30 | 
  31 |     // Verify creation
  32 |     await expect(sellerPage.getByText('Produk E2E Playwright')).toBeVisible();
  33 | 
  34 |     // 3. Edit Produk
  35 |     const row = sellerPage.locator('tr').filter({ hasText: 'Produk E2E Playwright' }).first();
  36 |     await row.getByRole('link', { name: 'Edit' }).click();
  37 |     
  38 |     await expect(sellerPage.getByText(/Edit Produk:/i)).toBeVisible();
  39 |     await sellerPage.getByLabel('Harga Jual (Rp)').fill('20000');
  40 |     await sellerPage.getByRole('button', { name: 'Perbarui' }).click();
  41 | 
  42 |     // Verify update
  43 |     // We check if it is still visible, the price update might be shown in the table
  44 |     await expect(sellerPage.getByText('Produk E2E Playwright')).toBeVisible();
  45 | 
  46 |     // 4. Delete Produk
  47 |     sellerPage.on('dialog', dialog => dialog.accept());
  48 |     const rowToDelete = sellerPage.locator('tr').filter({ hasText: 'Produk E2E Playwright' }).first();
  49 |     await rowToDelete.getByRole('button', { name: 'Hapus' }).click();
  50 | 
  51 |     // Verify deletion
  52 |     await expect(sellerPage.getByText('Produk E2E Playwright')).not.toBeVisible();
  53 |   });
  54 | });
  55 | 
```