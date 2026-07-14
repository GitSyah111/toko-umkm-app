import { test as base } from '@playwright/test';
import { LoginPage } from '../pages/LoginPage';
import { getSellerCredentials, getBuyerCredentials } from '../helpers/user';

type AuthFixtures = {
  sellerPage: typeof base;
  buyerPage: typeof base;
};

export const test = base.extend<AuthFixtures>({
  sellerPage: async ({ page }, use) => {
    const loginPage = new LoginPage(page);
    await loginPage.goto();
    const creds = getSellerCredentials();
    await loginPage.login(creds.email, creds.password);
    
    // Pass the authenticated page to the test
    await use(page);
  },
  
  buyerPage: async ({ page }, use) => {
    const loginPage = new LoginPage(page);
    await loginPage.goto();
    const creds = getBuyerCredentials();
    await loginPage.login(creds.email, creds.password);
    
    // Pass the authenticated page to the test
    await use(page);
  },
});

export { expect } from '@playwright/test';
