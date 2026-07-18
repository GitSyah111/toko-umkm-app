# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: e2e\specs\buyer\payments.spec.ts >> Buyer Payments Management >> buyer can view payment list
- Location: tests\e2e\specs\buyer\payments.spec.ts:1:101

# Error details

```
Error: expect(locator).toContainText(expected) failed

Locator: locator('h1').first()
Expected substring: "Pembayaran Saya"
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
- banner: Riwayat Pembayaran
- main:
  - heading "Daftar Pembayaran" [level=2]
  - table:
    - rowgroup:
      - row "ID Pembayaran Pesanan Tanggal Bayar Jumlah Metode Status Aksi":
        - columnheader "ID Pembayaran"
        - columnheader "Pesanan"
        - columnheader "Tanggal Bayar"
        - columnheader "Jumlah"
        - columnheader "Metode"
        - columnheader "Status"
        - columnheader "Aksi"
    - rowgroup:
      - 'row "#PAY-71 #71 - Rp 0 ewallet Gagal / Ditolak Detail"':
        - cell "#PAY-71"
        - cell "#71":
          - link "#71":
            - /url: http://127.0.0.1:8000/buyer/orders/71
        - cell "-"
        - cell "Rp 0"
        - cell "ewallet"
        - cell "Gagal / Ditolak"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/payments/71
      - 'row "#PAY-66 #66 12 Jul 2026 18:00 Rp 0 ewallet Berhasil Detail"':
        - cell "#PAY-66"
        - cell "#66":
          - link "#66":
            - /url: http://127.0.0.1:8000/buyer/orders/66
        - cell "12 Jul 2026 18:00"
        - cell "Rp 0"
        - cell "ewallet"
        - cell "Berhasil"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/payments/66
      - 'row "#PAY-56 #56 10 Jul 2026 20:49 Rp 0 bank transfer Berhasil Detail"':
        - cell "#PAY-56"
        - cell "#56":
          - link "#56":
            - /url: http://127.0.0.1:8000/buyer/orders/56
        - cell "10 Jul 2026 20:49"
        - cell "Rp 0"
        - cell "bank transfer"
        - cell "Berhasil"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/payments/56
      - 'row "#PAY-8 #8 - Rp 0 bank transfer Gagal / Ditolak Detail"':
        - cell "#PAY-8"
        - cell "#8":
          - link "#8":
            - /url: http://127.0.0.1:8000/buyer/orders/8
        - cell "-"
        - cell "Rp 0"
        - cell "bank transfer"
        - cell "Gagal / Ditolak"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/payments/8
      - 'row "#PAY-11 #11 06 Jul 2026 12:59 Rp 0 bank transfer Berhasil Detail"':
        - cell "#PAY-11"
        - cell "#11":
          - link "#11":
            - /url: http://127.0.0.1:8000/buyer/orders/11
        - cell "06 Jul 2026 12:59"
        - cell "Rp 0"
        - cell "bank transfer"
        - cell "Berhasil"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/payments/11
      - 'row "#PAY-19 #19 05 Jul 2026 12:43 Rp 0 ewallet Berhasil Detail"':
        - cell "#PAY-19"
        - cell "#19":
          - link "#19":
            - /url: http://127.0.0.1:8000/buyer/orders/19
        - cell "05 Jul 2026 12:43"
        - cell "Rp 0"
        - cell "ewallet"
        - cell "Berhasil"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/payments/19
      - 'row "#PAY-87 #87 01 Jul 2026 03:27 Rp 0 bank transfer Berhasil Detail"':
        - cell "#PAY-87"
        - cell "#87":
          - link "#87":
            - /url: http://127.0.0.1:8000/buyer/orders/87
        - cell "01 Jul 2026 03:27"
        - cell "Rp 0"
        - cell "bank transfer"
        - cell "Berhasil"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/payments/87
      - 'row "#PAY-40 #40 - Rp 0 ewallet Menunggu Konfirmasi Detail"':
        - cell "#PAY-40"
        - cell "#40":
          - link "#40":
            - /url: http://127.0.0.1:8000/buyer/orders/40
        - cell "-"
        - cell "Rp 0"
        - cell "ewallet"
        - cell "Menunggu Konfirmasi"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/payments/40
      - 'row "#PAY-33 #33 - Rp 0 ewallet Menunggu Konfirmasi Detail"':
        - cell "#PAY-33"
        - cell "#33":
          - link "#33":
            - /url: http://127.0.0.1:8000/buyer/orders/33
        - cell "-"
        - cell "Rp 0"
        - cell "ewallet"
        - cell "Menunggu Konfirmasi"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/payments/33
      - 'row "#PAY-70 #70 - Rp 0 qris Gagal / Ditolak Detail"':
        - cell "#PAY-70"
        - cell "#70":
          - link "#70":
            - /url: http://127.0.0.1:8000/buyer/orders/70
        - cell "-"
        - cell "Rp 0"
        - cell "qris"
        - cell "Gagal / Ditolak"
        - cell "Detail":
          - link "Detail":
            - /url: http://127.0.0.1:8000/buyer/payments/70
  - navigation "Pagination Navigation":
    - paragraph: Showing 1 to 10 of 16 results
    - text: "1"
    - link "Go to page 2":
      - /url: http://127.0.0.1:8000/buyer/payments?page=2
      - text: "2"
    - link "Next &raquo;":
      - /url: http://127.0.0.1:8000/buyer/payments?page=2
      - img
- contentinfo:
  - paragraph: © 2026 TokoKita. Hak Cipta Dilindungi Undang-Undang.
```

# Test source

```ts
> 1 | import { test, expect } from '../../fixtures/auth.fixture';
    |                                                                                                                                                                                                                                                   ^ Error: expect(locator).toContainText(expected) failed
  2 | 
  3 | test.describe('Buyer Payments Management', () => {
  4 |   test('buyer can view payment list', async ({ buyerPage }) => {
  5 |     await buyerPage.goto('/buyer/payments');
  6 |     await expect(buyerPage.locator('h1').first()).toContainText('Pembayaran Saya');
  7 |   });
  8 | });
  9 | 
```