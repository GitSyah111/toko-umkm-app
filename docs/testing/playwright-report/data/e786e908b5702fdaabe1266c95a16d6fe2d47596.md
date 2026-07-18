# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: e2e\specs\buyer\orders.spec.ts >> Buyer Orders Management >> buyer can view order list
- Location: tests\e2e\specs\buyer\orders.spec.ts:1:99

# Error details

```
Error: expect(locator).toContainText(expected) failed

Locator: locator('h1').first()
Expected substring: "Pesanan Saya"
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
    - text: Belanjaanku
    - link "Keranjang":
      - /url: http://127.0.0.1:8000/buyer/cart
      - img
      - text: Keranjang
    - link "Pesanan Saya":
      - /url: http://127.0.0.1:8000/buyer/orders
      - img
      - text: Pesanan Saya
    - link "Pembayaran":
      - /url: http://127.0.0.1:8000/buyer/payments
      - img
      - text: Pembayaran
    - link "Wishlist":
      - /url: http://127.0.0.1:8000/buyer/wishlist
      - img
      - text: Wishlist
- navigation:
  - link "TokoKita":
    - /url: http://127.0.0.1:8000/dashboard
  - link "Dashboard":
    - /url: http://127.0.0.1:8000/dashboard
  - button "Rina Wijaya":
    - text: Rina Wijaya
    - img
- banner: Pesanan Saya
- main:
  - heading "Daftar Pesanan" [level=2]
  - table:
    - rowgroup:
      - row "ID Pesanan Tanggal Toko Total Belanja Status Aksi":
        - columnheader "ID Pesanan"
        - columnheader "Tanggal"
        - columnheader "Toko"
        - columnheader "Total Belanja"
        - columnheader "Status"
        - columnheader "Aksi"
    - rowgroup:
      - row "#71 14 Jul 2026 20:55 Siti Fashion & Hijab Rp 126.000 Cancelled Detail":
        - cell "#71"
        - cell "14 Jul 2026 20:55"
        - cell "Siti Fashion & Hijab"
        - cell "Rp 126.000"
        - cell "Cancelled"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/orders/71
      - row "#66 12 Jul 2026 17:10 Agus Kuliner Nusantara Rp 473.000 Processing Detail":
        - cell "#66"
        - cell "12 Jul 2026 17:10"
        - cell "Agus Kuliner Nusantara"
        - cell "Rp 473.000"
        - cell "Processing"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/orders/66
      - row "#56 10 Jul 2026 20:07 Budi Jaya Elektronik Rp 1.751.000 Completed Detail":
        - cell "#56"
        - cell "10 Jul 2026 20:07"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 1.751.000"
        - cell "Completed"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/orders/56
      - row "#8 08 Jul 2026 03:18 Budi Jaya Elektronik Rp 1.146.000 Cancelled Detail":
        - cell "#8"
        - cell "08 Jul 2026 03:18"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 1.146.000"
        - cell "Cancelled"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/orders/8
      - row "#11 06 Jul 2026 12:16 Siti Fashion & Hijab Rp 191.000 Shipped Detail":
        - cell "#11"
        - cell "06 Jul 2026 12:16"
        - cell "Siti Fashion & Hijab"
        - cell "Rp 191.000"
        - cell "Shipped"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/orders/11
      - row "#19 05 Jul 2026 12:29 Agus Kuliner Nusantara Rp 93.000 Shipped Detail":
        - cell "#19"
        - cell "05 Jul 2026 12:29"
        - cell "Agus Kuliner Nusantara"
        - cell "Rp 93.000"
        - cell "Shipped"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/orders/19
      - row "#87 01 Jul 2026 02:37 Agus Kuliner Nusantara Rp 178.000 Completed Detail":
        - cell "#87"
        - cell "01 Jul 2026 02:37"
        - cell "Agus Kuliner Nusantara"
        - cell "Rp 178.000"
        - cell "Completed"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/orders/87
      - row "#40 30 Jun 2026 22:54 Agus Kuliner Nusantara Rp 411.000 Pending Detail":
        - cell "#40"
        - cell "30 Jun 2026 22:54"
        - cell "Agus Kuliner Nusantara"
        - cell "Rp 411.000"
        - cell "Pending"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/orders/40
      - row "#33 30 Jun 2026 04:03 Agus Kuliner Nusantara Rp 66.000 Pending Detail":
        - cell "#33"
        - cell "30 Jun 2026 04:03"
        - cell "Agus Kuliner Nusantara"
        - cell "Rp 66.000"
        - cell "Pending"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/orders/33
      - row "#70 29 Jun 2026 18:24 Budi Jaya Elektronik Rp 1.348.000 Cancelled Detail":
        - cell "#70"
        - cell "29 Jun 2026 18:24"
        - cell "Budi Jaya Elektronik"
        - cell "Rp 1.348.000"
        - cell "Cancelled"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/orders/70
  - navigation "Pagination Navigation":
    - paragraph: Showing 1 to 10 of 16 results
    - text: "1"
    - link "Go to page 2":
      - /url: http://127.0.0.1:8000/buyer/orders?page=2
      - text: "2"
    - link "Next &raquo;":
      - /url: http://127.0.0.1:8000/buyer/orders?page=2
      - img
- contentinfo:
  - paragraph: © 2026 TokoKita. Hak Cipta Dilindungi Undang-Undang.
```

# Test source

```ts
> 1  | import { test, expect } from '../../fixtures/auth.fixture';
     |                                                                                                                                                                                                                                             ^ Error: expect(locator).toContainText(expected) failed
  2  | 
  3  | test.describe('Buyer Orders Management', () => {
  4  |   test('buyer can view order list', async ({ buyerPage }) => {
  5  |     await buyerPage.goto('/buyer/orders');
  6  |     await expect(buyerPage.locator('h1').first()).toContainText('Pesanan Saya');
  7  |   });
  8  | 
  9  |   test('buyer can view order detail', async ({ buyerPage }) => {
  10 |     await buyerPage.goto('/buyer/orders');
  11 |     // Click on the first order detail link if exists
  12 |     const detailLink = buyerPage.locator('a:has-text("Detail")').first();
  13 |     if (await detailLink.isVisible()) {
  14 |       await detailLink.click();
  15 |       await expect(buyerPage.locator('h1').first()).toContainText('Detail Pesanan');
  16 |     }
  17 |   });
  18 | });
  19 | 
```