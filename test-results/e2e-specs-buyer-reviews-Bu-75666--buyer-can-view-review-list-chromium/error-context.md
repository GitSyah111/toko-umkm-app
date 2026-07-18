# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: e2e\specs\buyer\reviews.spec.ts >> Buyer Reviews Management >> buyer can view review list
- Location: tests\e2e\specs\buyer\reviews.spec.ts:1:100

# Error details

```
Error: expect(locator).toContainText(expected) failed

Locator: locator('h1').first()
Expected substring: "Ulasan Saya"
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
- banner:
  - heading "Ulasan Saya" [level=2]
- main:
  - table:
    - rowgroup:
      - row "Produk Pesanan Rating Aksi":
        - columnheader "Produk"
        - columnheader "Pesanan"
        - columnheader "Rating"
        - columnheader "Aksi"
    - rowgroup:
      - row "Belum ada ulasan.":
        - cell "Belum ada ulasan."
- contentinfo:
  - paragraph: © 2026 TokoKita. Hak Cipta Dilindungi Undang-Undang.
```

# Test source

```ts
> 1 | import { test, expect } from '../../fixtures/auth.fixture';
    |                                                                                                                                                                                                                                                ^ Error: expect(locator).toContainText(expected) failed
  2 | 
  3 | test.describe('Buyer Reviews Management', () => {
  4 |   test('buyer can view review list', async ({ buyerPage }) => {
  5 |     await buyerPage.goto('/buyer/reviews');
  6 |     await expect(buyerPage.locator('h1').first()).toContainText('Ulasan Saya');
  7 |   });
  8 | });
  9 | 
```