import { test, expect } from '../fixtures/auth.fixture';
import fs from 'fs';
import path from 'path';

test.describe('Spreadsheet Reports (Excel)', () => {
  const outputDir = path.resolve('docs/testing/spreadsheet-output');

  test.beforeAll(() => {
    if (!fs.existsSync(outputDir)) {
      fs.mkdirSync(outputDir, { recursive: true });
    }
  });

  test('Seller can generate Toko Sales Recap Excel', async ({ sellerPage }) => {
    const response = await sellerPage.request.get('/seller/toko-summary/excel-sales');
    expect(response.status()).toBe(200);
    const contentType = response.headers()['content-type'];
    expect(contentType).toContain('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    const contentDisposition = response.headers()['content-disposition'] || '';
    expect(contentDisposition).toMatch(/\.xlsx"?/);

    const buffer = await response.body();
    const filenameMatch = contentDisposition.match(/filename="?([^"]+)"?/);
    const filename = filenameMatch ? filenameMatch[1] : 'sales-recap.xlsx';
    const filePath = path.join(outputDir, filename);
    fs.writeFileSync(filePath, buffer);
    expect(fs.existsSync(filePath)).toBeTruthy();
  });
  
  test('Seller can generate Toko Net Profit Excel', async ({ sellerPage }) => {
    const response = await sellerPage.request.get('/seller/toko-summary/excel-profit');
    expect(response.status()).toBe(200);
    const contentType = response.headers()['content-type'];
    expect(contentType).toContain('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    const contentDisposition = response.headers()['content-disposition'] || '';
    expect(contentDisposition).toMatch(/\.xlsx"?/);

    const buffer = await response.body();
    const filenameMatch = contentDisposition.match(/filename="?([^"]+)"?/);
    const filename = filenameMatch ? filenameMatch[1] : 'net-profit.xlsx';
    const filePath = path.join(outputDir, filename);
    fs.writeFileSync(filePath, buffer);
    expect(fs.existsSync(filePath)).toBeTruthy();
  });

  test('Seller can generate Low Stock Products Excel', async ({ sellerPage }) => {
    const response = await sellerPage.request.get('/seller/produk/export-low-stock');
    expect(response.status()).toBe(200);
    const contentType = response.headers()['content-type'];
    expect(contentType).toContain('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    const contentDisposition = response.headers()['content-disposition'] || '';
    expect(contentDisposition).toMatch(/\.xlsx"?/);

    const buffer = await response.body();
    const filenameMatch = contentDisposition.match(/filename="?([^"]+)"?/);
    const filename = filenameMatch ? filenameMatch[1] : 'low-stock.xlsx';
    const filePath = path.join(outputDir, filename);
    fs.writeFileSync(filePath, buffer);
    expect(fs.existsSync(filePath)).toBeTruthy();
  });

  test('Seller can generate Cancelled Orders Excel', async ({ sellerPage }) => {
    const response = await sellerPage.request.get('/seller/orders/export-cancelled');
    expect(response.status()).toBe(200);
    const contentType = response.headers()['content-type'];
    expect(contentType).toContain('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    const contentDisposition = response.headers()['content-disposition'] || '';
    expect(contentDisposition).toMatch(/\.xlsx"?/);

    const buffer = await response.body();
    const filenameMatch = contentDisposition.match(/filename="?([^"]+)"?/);
    const filename = filenameMatch ? filenameMatch[1] : 'cancelled-orders.xlsx';
    const filePath = path.join(outputDir, filename);
    fs.writeFileSync(filePath, buffer);
    expect(fs.existsSync(filePath)).toBeTruthy();
  });

  test('Admin can generate Platform Performance Excel', async ({ adminPage }) => {
    const response = await adminPage.request.get('/admin/platform-summary/excel-performance');
    expect(response.status()).toBe(200);
    const contentType = response.headers()['content-type'];
    expect(contentType).toContain('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    
    const contentDisposition = response.headers()['content-disposition'] || '';
    expect(contentDisposition).toMatch(/\.xlsx"?/);

    const buffer = await response.body();
    const filenameMatch = contentDisposition.match(/filename="?([^"]+)"?/);
    const filename = filenameMatch ? filenameMatch[1] : 'platform-performance.xlsx';
    const filePath = path.join(outputDir, filename);
    fs.writeFileSync(filePath, buffer);
    expect(fs.existsSync(filePath)).toBeTruthy();
  });
});
