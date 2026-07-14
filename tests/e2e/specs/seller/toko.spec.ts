import { test, expect } from '@playwright/test';
import { LoginPage } from '../../pages/LoginPage';

test.describe('Seller Toko CRUD', () => {
  test('should be able to create, edit, and delete Toko', async ({ page }) => {
    // Log in as dani (a seller with NO toko and NO products)
    const loginPage = new LoginPage(page);
    await loginPage.goto();
    await loginPage.login('dani@seller.com', 'password123');

    // 1. Navigate to Toko Index
    await page.goto('/seller/toko');
    await expect(page.getByText('Daftar Toko', { exact: false })).toBeVisible();

    // 2. Create Toko
    await page.getByRole('link', { name: 'Buat Toko Baru' }).click();
    await expect(page.getByText('Buat Toko Baru', { exact: false })).toBeVisible();

    await page.getByLabel('Nama Toko').fill('Toko Dani Playwright');
    await page.getByLabel('Deskripsi').fill('Deskripsi toko baru dari E2E test');
    await page.getByLabel('Alamat').fill('Jl. Testing No. 123');
    await page.getByRole('button', { name: 'Simpan' }).click();

    // Verify creation
    await expect(page.getByText('Toko Dani Playwright')).toBeVisible();

    // 3. Edit Toko
    await page.getByRole('link', { name: 'Edit' }).first().click();
    await expect(page.getByText('Edit Toko:', { exact: false })).toBeVisible();
    
    await page.getByLabel('Nama Toko').fill('Toko Dani Edited');
    await page.getByRole('button', { name: 'Perbarui' }).click();
    
    // Verify successful update
    await expect(page.getByText('Toko Dani Edited')).toBeVisible();

    // 4. Delete Toko
    // Handle JS confirmation dialog
    page.on('dialog', dialog => dialog.accept());
    await page.getByRole('button', { name: 'Hapus' }).first().click();

    // Verify deletion
    await expect(page.getByText('Anda belum memiliki toko')).toBeVisible();
  });
});
