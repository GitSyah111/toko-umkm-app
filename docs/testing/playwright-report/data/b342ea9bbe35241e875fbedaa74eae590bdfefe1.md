# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: e2e\specs\buyer\orders.spec.ts >> Buyer Orders Management >> buyer can view order detail
- Location: tests\e2e\specs\buyer\orders.spec.ts:1:269

# Error details

```
Error: expect(locator).toContainText(expected) failed

Locator: locator('h1').first()
Expected substring: "Detail Pesanan"
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
- banner: "Detail Pesanan #71"
- main:
  - heading "Status Pesanan" [level=3]
  - text: "Status Saat Ini: CANCELLED"
  - heading "Informasi Pengiriman" [level=3]
  - term: Tanggal Order
  - definition: 14 Jul 2026 20:55
  - term: Toko Penjual
  - definition: Siti Fashion & Hijab
  - term: Alamat Tujuan
  - definition: Alamat Pembeli 6, Kota Tujuan
  - heading "Produk yang Dipesan" [level=3]
  - table:
    - rowgroup:
      - row "Produk Harga Qty Subtotal":
        - columnheader "Produk"
        - columnheader "Harga"
        - columnheader "Qty"
        - columnheader "Subtotal"
    - rowgroup:
      - row "Atasan Blouse Wanita Korea Rp 36.000 Rp 36.000":
        - cell "Atasan Blouse Wanita Korea"
        - cell "Rp 36.000"
        - cell
        - cell "Rp 36.000"
      - row "Kemeja Flanel Wanita Rp 54.000 Rp 54.000":
        - cell "Kemeja Flanel Wanita"
        - cell "Rp 54.000"
        - cell
        - cell "Rp 54.000"
    - rowgroup:
      - row "Total Harga Rp 90.000":
        - cell "Total Harga"
        - cell "Rp 90.000"
      - row "Ongkos Kirim Rp 36.000":
        - cell "Ongkos Kirim"
        - cell "Rp 36.000"
      - row "Total Pembayaran Rp 126.000":
        - cell "Total Pembayaran"
        - cell "Rp 126.000"
  - link "← Kembali ke Daftar Pesanan":
    - /url: http://127.0.0.1:8000/buyer/orders
  - link "Cetak Invoice (PDF)":
    - /url: http://127.0.0.1:8000/buyer/orders/71/invoice
- contentinfo:
  - paragraph: © 2026 TokoKita. Hak Cipta Dilindungi Undang-Undang.
```

# Test source

```ts
> 1  | import { test, expect } from '../../fixtures/auth.fixture';
     |                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      ^ Error: expect(locator).toContainText(expected) failed
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