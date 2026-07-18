import { test, expect } from '../../fixtures/auth.fixture';

test.describe('Buyer Reviews Management', () => {
  test('buyer can view review list', async ({ buyerPage }) => {
    await buyerPage.goto('/buyer/reviews');
    await expect(buyerPage.locator('h2').first()).toContainText('Ulasan Saya');
  });
});
