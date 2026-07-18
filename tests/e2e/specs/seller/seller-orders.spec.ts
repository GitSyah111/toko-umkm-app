import { test, expect } from '../../fixtures/auth.fixture';

test.describe('Seller Orders Management', () => {
  test('seller can view incoming orders', async ({ sellerPage }) => {
    await sellerPage.goto('/seller/orders');
    await expect(sellerPage.locator('h2').first()).toContainText('Pesanan Masuk');
  });
});
