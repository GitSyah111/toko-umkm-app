import { chromium } from 'playwright';

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({ viewport: { width: 1280, height: 720 } });
  const page = await context.newPage();
  const baseURL = 'http://127.0.0.1:8080';

  console.log("Capturing Home...");
  await page.goto(baseURL + '/');
  await page.waitForTimeout(1000);
  await page.screenshot({ path: 'docs/images/home.png' });

  console.log("Capturing Login...");
  await page.goto(baseURL + '/login');
  await page.waitForTimeout(1000);
  await page.screenshot({ path: 'docs/images/login.png' });

  console.log("Capturing Register...");
  await page.goto(baseURL + '/register');
  await page.waitForTimeout(1000);
  await page.screenshot({ path: 'docs/images/register.png' });

  console.log("Capturing Admin...");
  await page.goto(baseURL + '/login');
  await page.fill('input[name="email"]', 'admin@toko.com');
  await page.fill('input[name="password"]', 'password');
  await page.click('button[type="submit"]');
  await page.waitForTimeout(3000); // wait instead of waitForURL
  await page.screenshot({ path: 'docs/images/admin.png' });

  console.log("Capturing Admin Users...");
  await page.goto(baseURL + '/admin/users');
  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'docs/images/admin-users.png' });

  console.log("Capturing Admin Reports...");
  await page.goto(baseURL + '/admin/platform-summary');
  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'docs/images/admin-reports.png' });

  // Logout
  await context.clearCookies();

  console.log("Capturing Seller...");
  await page.goto(baseURL + '/login');
  await page.fill('input[name="email"]', 'budi@seller.com');
  await page.fill('input[name="password"]', 'password');
  await page.click('button[type="submit"]');
  await page.waitForTimeout(3000);
  await page.screenshot({ path: 'docs/images/seller.png' });

  console.log("Capturing Seller Reports...");
  await page.goto(baseURL + '/seller/toko-summary');
  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'docs/images/seller-reports.png' });

  // Logout
  await context.clearCookies();

  console.log("Capturing Buyer...");
  await page.goto(baseURL + '/login');
  await page.fill('input[name="email"]', 'rina@buyer.com');
  await page.fill('input[name="password"]', 'password');
  await page.click('button[type="submit"]');
  await page.waitForTimeout(3000);
  await page.goto(baseURL + '/'); // go to home for catalog
  await page.waitForTimeout(2000);
  await page.screenshot({ path: 'docs/images/buyer.png' });

  await browser.close();
  console.log("Screenshots captured!");
})();
