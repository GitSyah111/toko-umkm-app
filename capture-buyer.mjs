import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 1280, height: 720 } });
  const page = await context.newPage();
  const baseURL = 'http://127.0.0.1:8080';

  console.log("Logging in as Buyer...");
  await page.goto(baseURL + '/login');
  await page.fill('input[name="email"]', 'rina@buyer.com');
  await page.fill('input[name="password"]', 'password');
  await page.click('button[type="submit"]');
  await page.waitForTimeout(3000); // wait for redirect

  console.log("Capturing Buyer Dashboard/Orders...");
  await page.goto(baseURL + '/buyer/orders');
  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'docs/images/buyer-dashboard.png' });

  console.log("Capturing Buyer Cart...");
  await page.goto(baseURL + '/buyer/cart');
  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'docs/images/buyer-cart.png' });

  await browser.close();
  console.log("Buyer screenshots captured!");
})();
