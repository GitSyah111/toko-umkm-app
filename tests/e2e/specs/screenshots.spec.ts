import { test, expect } from '../fixtures/auth.fixture';

test.describe('Automated Screenshots', () => {
  test('Capture Guest Pages', async ({ page }) => {
    await page.goto('/');
    await page.screenshot({ path: 'docs/images/home.png' });
    
    await page.goto('/login');
    await page.screenshot({ path: 'docs/images/login.png' });
    
    await page.goto('/register');
    await page.screenshot({ path: 'docs/images/register.png' });
  });

  test('Capture Buyer Pages', async ({ buyerPage }) => {
    // Buyer Catalog
    await buyerPage.goto('/');
    await buyerPage.waitForTimeout(1000);
    await buyerPage.screenshot({ path: 'docs/images/buyer.png' });

    // Buyer Dashboard / Orders
    await buyerPage.goto('/buyer/orders');
    await buyerPage.waitForTimeout(1000);
    await buyerPage.screenshot({ path: 'docs/images/buyer-dashboard.png' });
    
    // Buyer Cart
    await buyerPage.goto('/buyer/cart');
    await buyerPage.waitForTimeout(1000);
    await buyerPage.screenshot({ path: 'docs/images/buyer-cart.png' });
  });

  test('Capture Seller Pages', async ({ sellerPage }) => {
    // Seller Dashboard
    await sellerPage.goto('/seller/toko');
    await sellerPage.waitForTimeout(1000);
    await sellerPage.screenshot({ path: 'docs/images/seller.png' });
    
    // Seller Products
    await sellerPage.goto('/seller/produk');
    await sellerPage.waitForTimeout(1000);
    await sellerPage.screenshot({ path: 'docs/images/seller-products.png' });
    
    // Seller Orders
    await sellerPage.goto('/seller/orders');
    await sellerPage.waitForTimeout(1000);
    await sellerPage.screenshot({ path: 'docs/images/seller-orders.png' });
    
    // Seller Reports
    await sellerPage.goto('/seller/toko-summary');
    await sellerPage.waitForTimeout(1000);
    await sellerPage.screenshot({ path: 'docs/images/seller-reports.png' });
  });

  test('Capture Admin Pages', async ({ adminPage }) => {
    // Admin Dashboard
    await adminPage.goto('/admin/dashboard');
    await adminPage.waitForTimeout(1000);
    await adminPage.screenshot({ path: 'docs/images/admin.png' });
    
    // Admin Users
    await adminPage.goto('/admin/users');
    await adminPage.waitForTimeout(1000);
    await adminPage.screenshot({ path: 'docs/images/admin-users.png' });
    
    // Admin Reports
    await adminPage.goto('/admin/platform-summary');
    await adminPage.waitForTimeout(1000);
    await adminPage.screenshot({ path: 'docs/images/admin-reports.png' });
  });
});
