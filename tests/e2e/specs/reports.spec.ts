import { test, expect } from '../fixtures/auth.fixture';
import fs from 'fs';
import path from 'path';

test.describe('Printed Reports (PDF)', () => {
  const outputDir = path.resolve('docs/testing/pdf-output');

  test.beforeAll(() => {
    if (!fs.existsSync(outputDir)) {
      fs.mkdirSync(outputDir, { recursive: true });
    }
  });

  test('Seller can generate Toko Sales Recap PDF', async ({ sellerPage }) => {
    const response = await sellerPage.request.get('/seller/toko-summary/pdf-sales');
    expect(response.status()).toBe(200);
    const contentType = response.headers()['content-type'];
    expect(contentType).toContain('application/pdf');
    
    const contentDisposition = response.headers()['content-disposition'] || '';
    expect(contentDisposition).toMatch(/filename="?sales-recap\.pdf"?/);

    const buffer = await response.body();
    const filePath = path.join(outputDir, 'sales-recap.pdf');
    fs.writeFileSync(filePath, buffer);
    expect(fs.existsSync(filePath)).toBeTruthy();
  });
  
  test('Seller can generate Toko Net Profit PDF', async ({ sellerPage }) => {
    const response = await sellerPage.request.get('/seller/toko-summary/pdf-profit');
    expect(response.status()).toBe(200);
    const contentType = response.headers()['content-type'];
    expect(contentType).toContain('application/pdf');
    
    const contentDisposition = response.headers()['content-disposition'] || '';
    expect(contentDisposition).toMatch(/filename="?net-profit\.pdf"?/);

    const buffer = await response.body();
    const filePath = path.join(outputDir, 'net-profit.pdf');
    fs.writeFileSync(filePath, buffer);
    expect(fs.existsSync(filePath)).toBeTruthy();
  });

  test('Seller can generate Order Invoice and Shipping Label PDFs', async ({ sellerPage }) => {
    await sellerPage.goto('/seller/orders');
    
    const detailLink = sellerPage.getByRole('link', { name: 'Proses / Detail' }).first();
    const hasOrder = await detailLink.count() > 0;
    
    if (!hasOrder) {
      test.skip('No orders found for seller to test PDF generation.');
      return;
    }

    await detailLink.click();
    await expect(sellerPage.getByText('Informasi Pesanan')).toBeVisible();

    const invoiceHref = await sellerPage.getByRole('link', { name: 'Cetak Invoice' }).getAttribute('href');
    const shippingLabelHref = await sellerPage.getByRole('link', { name: 'Cetak Label Pengiriman' }).getAttribute('href');

    expect(invoiceHref).toBeTruthy();
    expect(shippingLabelHref).toBeTruthy();

    // Fetch and Save Invoice PDF
    const invoiceRes = await sellerPage.request.get(invoiceHref!);
    expect(invoiceRes.status()).toBe(200);
    expect(invoiceRes.headers()['content-type']).toContain('application/pdf');
    expect(invoiceRes.headers()['content-disposition']).toMatch(/filename="?invoice-\d+\.pdf"?/);
    
    const invoiceFilename = invoiceRes.headers()['content-disposition'].match(/filename="?([^"]+)"?/)?.[1] || 'seller-invoice.pdf';
    const invoicePath = path.join(outputDir, invoiceFilename);
    fs.writeFileSync(invoicePath, await invoiceRes.body());
    expect(fs.existsSync(invoicePath)).toBeTruthy();

    // Fetch and Save Shipping Label PDF
    const shippingRes = await sellerPage.request.get(shippingLabelHref!);
    expect(shippingRes.status()).toBe(200);
    expect(shippingRes.headers()['content-type']).toContain('application/pdf');
    expect(shippingRes.headers()['content-disposition']).toMatch(/filename="?shipping-label-\d+\.pdf"?/);

    const shippingFilename = shippingRes.headers()['content-disposition'].match(/filename="?([^"]+)"?/)?.[1] || 'shipping-label.pdf';
    const shippingPath = path.join(outputDir, shippingFilename);
    fs.writeFileSync(shippingPath, await shippingRes.body());
    expect(fs.existsSync(shippingPath)).toBeTruthy();
  });

  test('Buyer can generate Order Invoice PDF', async ({ buyerPage }) => {
    await buyerPage.goto('/buyer/orders');

    const detailLink = buyerPage.getByRole('link', { name: 'Detail' }).first();
    const hasOrder = await detailLink.count() > 0;
    
    if (!hasOrder) {
      test.skip('No orders found for buyer to test PDF generation.');
      return;
    }

    await detailLink.click();
    await expect(buyerPage.getByText('Status Pesanan')).toBeVisible();

    const invoiceHref = await buyerPage.getByRole('link', { name: /Cetak Invoice/i }).getAttribute('href');
    expect(invoiceHref).toBeTruthy();

    const invoiceRes = await buyerPage.request.get(invoiceHref!);
    expect(invoiceRes.status()).toBe(200);
    expect(invoiceRes.headers()['content-type']).toContain('application/pdf');
    expect(invoiceRes.headers()['content-disposition']).toMatch(/filename="?invoice-\d+\.pdf"?/);

    const invoiceFilenameMatch = invoiceRes.headers()['content-disposition'].match(/filename="?([^"]+)"?/);
    const invoiceFilename = invoiceFilenameMatch ? `buyer-${invoiceFilenameMatch[1]}` : 'buyer-invoice.pdf';
    const invoicePath = path.join(outputDir, invoiceFilename);
    fs.writeFileSync(invoicePath, await invoiceRes.body());
    expect(fs.existsSync(invoicePath)).toBeTruthy();
  });
});
