# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: e2e\specs\seller\seller-orders.spec.ts >> Seller Orders Management >> seller can view incoming orders
- Location: tests\e2e\specs\seller\seller-orders.spec.ts:1:100

# Error details

```
Error: expect(locator).toContainText(expected) failed

Locator: locator('h1').first()
Expected substring: "Daftar Pesanan"
Timeout: 5000ms
Error: element(s) not found

Call log:
  - Expect "toContainText" with timeout 5000ms
  - waiting for locator('h1').first()

```

```yaml
- complementary:
  - link "TokoKita":
    - /url: http://127.0.0.1:8000/dashboard
  - navigation:
    - link "Dashboard":
      - /url: http://127.0.0.1:8000/dashboard
      - img
      - text: Dashboard
    - separator
    - text: Toko Saya
    - link "Profil Toko":
      - /url: http://127.0.0.1:8000/seller/toko
      - img
      - text: Profil Toko
    - link "Produk":
      - /url: http://127.0.0.1:8000/seller/produk
      - img
      - text: Produk
    - link "Pesanan Masuk":
      - /url: http://127.0.0.1:8000/seller/orders
      - img
      - text: Pesanan Masuk
- navigation:
  - link "TokoKita":
    - /url: http://127.0.0.1:8000/dashboard
  - link "Dashboard":
    - /url: http://127.0.0.1:8000/dashboard
  - button "Budi Santoso":
    - text: Budi Santoso
    - img
- banner: Pesanan Masuk
- main:
  - heading "Daftar Pesanan" [level=2]
  - link "Export Pesanan Dibatalkan (Excel)":
    - /url: http://127.0.0.1:8000/seller/orders/export-cancelled
  - table:
    - rowgroup:
      - row "ID Pesanan Tanggal Pembeli Toko Total Status Aksi":
        - columnheader "ID Pesanan"
        - columnheader "Tanggal"
        - columnheader "Pembeli"
        - columnheader "Toko"
        - columnheader "Total"
        - columnheader "Status"
        - columnheader "Aksi"
    - rowgroup:
      - row "#13 17 Jul 2026 02:33 Irfan Hakim Budi Jaya Elektronik Rp 362.000 Processing Proses / Detail":
        - cell "#13"
        - cell "17 Jul 2026 02:33"
        - cell "Irfan Hakim"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 362.000"
        - cell "Processing"
        - cell "Proses / Detail":
          - link "Proses / Detail":
            - /url: http://127.0.0.1:8000/seller/orders/13
      - row "#4 17 Jul 2026 01:24 Maya Sari Budi Jaya Elektronik Rp 418.000 Cancelled Proses / Detail":
        - cell "#4"
        - cell "17 Jul 2026 01:24"
        - cell "Maya Sari"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 418.000"
        - cell "Cancelled"
        - cell "Proses / Detail":
          - link "Proses / Detail":
            - /url: http://127.0.0.1:8000/seller/orders/4
      - row "#81 16 Jul 2026 01:40 Ahmad Fauzi Budi Jaya Elektronik Rp 957.000 Paid Proses / Detail":
        - cell "#81"
        - cell "16 Jul 2026 01:40"
        - cell "Ahmad Fauzi"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 957.000"
        - cell "Paid"
        - cell "Proses / Detail":
          - link "Proses / Detail":
            - /url: http://127.0.0.1:8000/seller/orders/81
      - row "#67 15 Jul 2026 09:46 Joko Susanto Budi Jaya Elektronik Rp 279.000 Paid Proses / Detail":
        - cell "#67"
        - cell "15 Jul 2026 09:46"
        - cell "Joko Susanto"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 279.000"
        - cell "Paid"
        - cell "Proses / Detail":
          - link "Proses / Detail":
            - /url: http://127.0.0.1:8000/seller/orders/67
      - row "#58 14 Jul 2026 00:44 Dewi Lestari Budi Jaya Elektronik Rp 560.000 Processing Proses / Detail":
        - cell "#58"
        - cell "14 Jul 2026 00:44"
        - cell "Dewi Lestari"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 560.000"
        - cell "Processing"
        - cell "Proses / Detail":
          - link "Proses / Detail":
            - /url: http://127.0.0.1:8000/seller/orders/58
      - row "#6 13 Jul 2026 20:30 Joko Susanto Budi Jaya Elektronik Rp 580.000 Shipped Proses / Detail":
        - cell "#6"
        - cell "13 Jul 2026 20:30"
        - cell "Joko Susanto"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 580.000"
        - cell "Shipped"
        - cell "Proses / Detail":
          - link "Proses / Detail":
            - /url: http://127.0.0.1:8000/seller/orders/6
      - row "#26 13 Jul 2026 10:47 Maya Sari Budi Jaya Elektronik Rp 1.679.000 Processing Proses / Detail":
        - cell "#26"
        - cell "13 Jul 2026 10:47"
        - cell "Maya Sari"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 1.679.000"
        - cell "Processing"
        - cell "Proses / Detail":
          - link "Proses / Detail":
            - /url: http://127.0.0.1:8000/seller/orders/26
      - row "#28 12 Jul 2026 02:01 Nina Kartika Budi Jaya Elektronik Rp 1.062.000 Pending Proses / Detail":
        - cell "#28"
        - cell "12 Jul 2026 02:01"
        - cell "Nina Kartika"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 1.062.000"
        - cell "Pending"
        - cell "Proses / Detail":
          - link "Proses / Detail":
            - /url: http://127.0.0.1:8000/seller/orders/28
      - row "#29 11 Jul 2026 19:10 Dewi Lestari Budi Jaya Elektronik Rp 136.000 Paid Proses / Detail":
        - cell "#29"
        - cell "11 Jul 2026 19:10"
        - cell "Dewi Lestari"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 136.000"
        - cell "Paid"
        - cell "Proses / Detail":
          - link "Proses / Detail":
            - /url: http://127.0.0.1:8000/seller/orders/29
      - row "#56 10 Jul 2026 20:07 Rina Wijaya Budi Jaya Elektronik Rp 1.751.000 Completed Proses / Detail":
        - cell "#56"
        - cell "10 Jul 2026 20:07"
        - cell "Rina Wijaya"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 1.751.000"
        - cell "Completed"
        - cell "Proses / Detail":
          - link "Proses / Detail":
            - /url: http://127.0.0.1:8000/seller/orders/56
  - navigation "Pagination Navigation":
    - paragraph: Showing 1 to 10 of 30 results
    - text: "1"
    - link "Go to page 2":
      - /url: http://127.0.0.1:8000/seller/orders?page=2
      - text: "2"
    - link "Go to page 3":
      - /url: http://127.0.0.1:8000/seller/orders?page=3
      - text: "3"
    - link "Next &raquo;":
      - /url: http://127.0.0.1:8000/seller/orders?page=2
      - img
- contentinfo:
  - paragraph: © 2026 TokoKita. Hak Cipta Dilindungi Undang-Undang.
```

# Test source

```ts
> 1 | import { test, expect } from '../../fixtures/auth.fixture';
    |                                                                                                                                                                                                                                                        ^ Error: expect(locator).toContainText(expected) failed
  2 | 
  3 | test.describe('Seller Orders Management', () => {
  4 |   test('seller can view incoming orders', async ({ sellerPage }) => {
  5 |     await sellerPage.goto('/seller/orders');
  6 |     await expect(sellerPage.locator('h1').first()).toContainText('Daftar Pesanan');
  7 |   });
  8 | });
  9 | 
```