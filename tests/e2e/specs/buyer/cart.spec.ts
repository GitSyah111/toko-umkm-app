import { test, expect } from '../../fixtures/auth.fixture';

test.describe('Buyer Cart CRUD', () => {
  test('should view empty cart, and handle missing add-to-cart UI gracefully', async ({ buyerPage }) => {
    // 1. Navigate to Cart Index
    await buyerPage.goto('/buyer/cart');
    await expect(buyerPage.getByText('Keranjang Belanja', { exact: false })).toBeVisible();

    // Since there is no public "Produk" page to click "Add to Cart" yet,
    // we can only verify the Empty state of the cart for a new buyer (or seeded buyer without cart)
    const emptyMessage = buyerPage.getByText('Keranjang masih kosong');
    
    if (await emptyMessage.isVisible()) {
      // Test passed for empty state
      await expect(emptyMessage).toBeVisible();
    } else {
      // If there are items (e.g. from previous tests or seeded data), test Update and Delete
      // 2. Update Quantity
      const updateButton = buyerPage.getByRole('button', { name: 'Update' }).first();
      await buyerPage.locator('input[name="kuantitas"]').first().fill('2');
      await updateButton.click();
      await expect(buyerPage.getByText('Kuantitas berhasil diperbarui')).toBeVisible();

      // 3. Delete from Cart
      buyerPage.on('dialog', dialog => dialog.accept());
      const deleteButton = buyerPage.getByRole('button', { name: 'Hapus' }).first();
      await deleteButton.click();
      await expect(buyerPage.getByText('Produk dihapus dari keranjang')).toBeVisible();
    }
  });
});
