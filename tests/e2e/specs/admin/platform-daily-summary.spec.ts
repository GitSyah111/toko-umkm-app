import { test, expect } from '../../fixtures/auth.fixture';

test.describe('Platform Daily Summary CRUD', () => {
  test('Admin can view, create, edit, and delete platform daily summary', async ({ adminPage }) => {
    // 1. View Index
    await adminPage.goto('/admin/platform-summary');
    await expect(adminPage.locator('h2')).toContainText('Platform Daily Summary');

    // 2. Create
    await adminPage.click('text=Create New');
    await expect(adminPage).toHaveURL(/\/admin\/platform-summary\/create/);
    
    await adminPage.fill('input[name="tanggal"]', '2099-01-01');
    await adminPage.fill('input[name="total_gmv"]', '5000000');
    await adminPage.fill('input[name="total_orders"]', '100');
    await adminPage.fill('input[name="total_active_tokos"]', '25');
    await adminPage.click('button:has-text("Save")');

    await expect(adminPage).toHaveURL(/\/admin\/platform-summary/);
    await expect(adminPage.locator('text=Summary created successfully.').first()).toBeVisible();
    await expect(adminPage.locator('td').filter({ hasText: '2099-01-01' })).toBeVisible();

    // 3. Edit
    await adminPage.locator('tr', { hasText: '2099-01-01' }).locator('text=Edit').click();
    await expect(adminPage).toHaveURL(/\/admin\/platform-summary\/\d+\/edit/);

    await adminPage.fill('input[name="total_orders"]', '120');
    await adminPage.click('button:has-text("Update")');

    await expect(adminPage).toHaveURL(/\/admin\/platform-summary/);
    await expect(adminPage.locator('text=Summary updated successfully.').first()).toBeVisible();
    await expect(adminPage.locator('tr', { hasText: '2099-01-01' }).locator('text=120')).toBeVisible();

    // 4. Show
    await adminPage.locator('tr', { hasText: '2099-01-01' }).locator('text=View').click();
    await expect(adminPage).toHaveURL(/\/admin\/platform-summary\/\d+/);
    await expect(adminPage.locator('text=120')).toBeVisible();

    // 5. Delete
    await adminPage.click('text=Back to List');
    await expect(adminPage).toHaveURL(/\/admin\/platform-summary/);

    // Accept dialog for deletion
    adminPage.once('dialog', dialog => dialog.accept());
    await adminPage.locator('tr', { hasText: '2099-01-01' }).locator('text=Delete').click();

    await expect(adminPage.locator('text=Summary deleted successfully.').first()).toBeVisible();
    await expect(adminPage.locator('td', { hasText: '2099-01-01' })).toHaveCount(0);
  });
});
