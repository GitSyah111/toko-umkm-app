import { test, expect } from '../../fixtures/auth.fixture';

test.describe('Buyer Orders Management', () => {
  test('buyer can view order list', async ({ buyerPage }) => {
    await buyerPage.goto('/buyer/orders');
    await expect(buyerPage.locator('h2').first()).toContainText('Pesanan Saya');
  });

  test('buyer can view order detail', async ({ buyerPage }) => {
    await buyerPage.goto('/buyer/orders');
    // Click on the first order detail link if exists
    const detailLink = buyerPage.locator('a:has-text("Detail")').first();
    if (await detailLink.isVisible()) {
      await detailLink.click();
      await expect(buyerPage.locator('h2').first()).toContainText('Detail Pesanan');
    }
  });
});
