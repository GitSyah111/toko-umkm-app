import { test, expect } from '../../fixtures/auth.fixture';

test.describe('Seller Produk CRUD', () => {
  test('should be able to create, edit, and delete Produk', async ({ sellerPage }) => {
    // 1. Navigate to Produk Index
    await sellerPage.goto('/seller/produk');
    await expect(sellerPage.getByRole('heading', { name: 'Daftar Produk' })).toBeVisible();

    // 2. Create Produk
    await sellerPage.getByRole('link', { name: 'Tambah Produk' }).click();
    await expect(sellerPage.getByText('Tambah Produk Baru', { exact: false })).toBeVisible();

    // Fill form
    // Select first toko
    await sellerPage.getByLabel('Toko').selectOption({ index: 1 });
    await sellerPage.getByLabel('Nama Produk').fill('Produk E2E Playwright');
    await sellerPage.getByLabel('Deskripsi').fill('Deskripsi produk testing');
    await sellerPage.getByLabel('Harga (Rp)').fill('15000');
    await sellerPage.getByLabel('Stok').fill('10');
    await sellerPage.getByLabel('Status').selectOption('aktif');
    
    await sellerPage.getByRole('button', { name: 'Simpan' }).click();
    
    await sellerPage.waitForLoadState('networkidle');
    const pageText = await sellerPage.innerText('body');
    console.log('PRODUK PAGE TEXT AFTER CREATE:', pageText);

    // Verify creation
    await expect(sellerPage.getByText('Produk E2E Playwright')).toBeVisible();

    // 3. Edit Produk
    const row = sellerPage.locator('tr').filter({ hasText: 'Produk E2E Playwright' }).first();
    await row.getByRole('link', { name: 'Edit' }).click();
    
    await expect(sellerPage.getByText(/Edit Produk:/i)).toBeVisible();
    await sellerPage.getByLabel('Harga (Rp)').fill('20000');
    await sellerPage.getByRole('button', { name: 'Perbarui' }).click();

    // Verify update
    // We check if it is still visible, the price update might be shown in the table
    await expect(sellerPage.getByText('Produk E2E Playwright')).toBeVisible();

    // 4. Delete Produk
    sellerPage.on('dialog', dialog => dialog.accept());
    const rowToDelete = sellerPage.locator('tr').filter({ hasText: 'Produk E2E Playwright' }).first();
    await rowToDelete.getByRole('button', { name: 'Hapus' }).click();

    // Verify deletion
    await expect(sellerPage.getByText('Produk E2E Playwright')).not.toBeVisible();
  });
});
