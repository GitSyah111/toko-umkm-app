import { test, expect } from '../../fixtures/auth.fixture';

test.describe('Buyer Payments Management', () => {
  test('buyer can view payment list', async ({ buyerPage }) => {
    await buyerPage.goto('/buyer/payments');
    await expect(buyerPage.locator('h2').first()).toContainText('Pembayaran Saya');
  });
});
