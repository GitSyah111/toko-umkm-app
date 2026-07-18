import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 1280, height: 720 } });
  const page = await context.newPage();
  const baseURL = 'http://127.0.0.1:8080';

  console.log("Logging in as Seller...");
  await page.goto(baseURL + '/login');
  await page.fill('input[name="email"]', 'budi@seller.com');
  await page.fill('input[name="password"]', 'password');
  await page.click('button[type="submit"]');
  await page.waitForTimeout(3000); // wait for login redirect

  console.log("Capturing Seller Products...");
  await page.goto(baseURL + '/seller/produk');
  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'docs/images/seller-products.png' });

  console.log("Capturing Seller Orders...");
  await page.goto(baseURL + '/seller/orders');
  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'docs/images/seller-orders.png' });

  await browser.close();
  console.log("Additional screenshots captured!");
})();
