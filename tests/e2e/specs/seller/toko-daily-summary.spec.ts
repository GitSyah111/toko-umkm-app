import { test, expect } from '../../fixtures/auth.fixture';

test.describe('Toko Daily Summary CRUD', () => {
  test('Seller can view, create, edit, and delete toko daily summary', async ({ sellerPage }) => {
    // 1. View Index
    await sellerPage.goto('/seller/toko-summary');
    await expect(sellerPage.locator('h2')).toContainText('Toko Daily Summary');

    // 2. Create
    await sellerPage.click('text=Create New');
    await expect(sellerPage).toHaveURL(/\/seller\/toko-summary\/create/);
    
    await sellerPage.fill('input[name="tanggal"]', '2099-01-01');
    await sellerPage.fill('input[name="total_revenue"]', '1500000');
    await sellerPage.fill('input[name="total_orders"]', '10');
    await sellerPage.click('button:has-text("Save")');

    await expect(sellerPage).toHaveURL(/\/seller\/toko-summary/);
    await expect(sellerPage.locator('text=Summary created successfully.').first()).toBeVisible();
    await expect(sellerPage.locator('td').filter({ hasText: '2099-01-01' })).toBeVisible();

    // 3. Edit
    await sellerPage.locator('tr', { hasText: '2099-01-01' }).locator('text=Edit').click();
    await expect(sellerPage).toHaveURL(/\/seller\/toko-summary\/\d+\/edit/);

    await sellerPage.fill('input[name="total_orders"]', '15');
    await sellerPage.click('button:has-text("Update")');

    await expect(sellerPage).toHaveURL(/\/seller\/toko-summary/);
    await expect(sellerPage.locator('text=Summary updated successfully.').first()).toBeVisible();
    await expect(sellerPage.locator('tr', { hasText: '2099-01-01' }).locator('text=15')).toBeVisible();

    // 4. Show
    await sellerPage.locator('tr', { hasText: '2099-01-01' }).locator('text=View').click();
    await expect(sellerPage).toHaveURL(/\/seller\/toko-summary\/\d+/);
    await expect(sellerPage.locator('text=15')).toBeVisible();

    // 5. Delete
    await sellerPage.click('text=Back to List');
    await expect(sellerPage).toHaveURL(/\/seller\/toko-summary/);

    // Accept dialog for deletion
    sellerPage.once('dialog', dialog => dialog.accept());
    await sellerPage.locator('tr', { hasText: '2099-01-01' }).locator('button', { hasText: 'Delete' }).click();

    await expect(sellerPage.locator('text=Summary deleted successfully.').first()).toBeVisible();
    await expect(sellerPage.locator('td', { hasText: '2099-01-01' })).toHaveCount(0);
  });
});
