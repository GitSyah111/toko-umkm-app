<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\PlatformDailySummaryController;
use App\Http\Controllers\Admin\SellerPerformanceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role: Penjual (Seller)
Route::middleware(['auth', 'role:penjual'])->prefix('seller')->name('seller.')->group(function () {
    Route::resource('toko', TokoController::class);
    Route::get('produk/export-low-stock', [ProdukController::class, 'exportLowStockExcel'])->name('produk.export-low-stock');
    Route::resource('produk', ProdukController::class);
    Route::get('orders/{order}/invoice', [SellerOrderController::class, 'printInvoice'])->name('orders.invoice');
    Route::get('orders/{order}/shipping-label', [SellerOrderController::class, 'printShippingLabel'])->name('orders.shipping-label');
    Route::get('orders/export-cancelled', [SellerOrderController::class, 'exportCancelledExcel'])->name('orders.export-cancelled');
    Route::resource('orders', SellerOrderController::class)->only(['index', 'show', 'update']);
    Route::get('toko-summary/pdf-sales', [App\Http\Controllers\Seller\TokoDailySummaryController::class, 'printSalesRecap'])->name('toko-summary.sales-pdf');
    Route::get('toko-summary/pdf-profit', [App\Http\Controllers\Seller\TokoDailySummaryController::class, 'printNetProfit'])->name('toko-summary.profit-pdf');
    Route::get('toko-summary/excel-sales', [App\Http\Controllers\Seller\TokoDailySummaryController::class, 'exportSalesRecapExcel'])->name('toko-summary.sales-excel');
    Route::get('toko-summary/excel-profit', [App\Http\Controllers\Seller\TokoDailySummaryController::class, 'exportNetProfitExcel'])->name('toko-summary.profit-excel');
    Route::resource('toko-summary', App\Http\Controllers\Seller\TokoDailySummaryController::class);
});

use App\Http\Controllers\ReviewController;

// Role: Pembeli (Buyer)
Route::middleware(['auth', 'role:pembeli'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::resource('cart', CartController::class);
    Route::get('orders/{order}/invoice', [OrderController::class, 'printInvoice'])->name('orders.invoice');
    Route::resource('orders', OrderController::class);
    Route::resource('payments', PaymentController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('wishlist', WishlistController::class);
    Route::resource('reviews', ReviewController::class);
});

// Role: Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::get('platform-summary/excel-performance', [PlatformDailySummaryController::class, 'exportPerformanceExcel'])->name('platform-summary.excel');
    Route::resource('platform-summary', PlatformDailySummaryController::class);
    
    // Review Analysis
    Route::get('reviews/analysis', [App\Http\Controllers\Admin\ReviewAnalysisController::class, 'index'])->name('reviews.analysis');
    Route::patch('reviews/{review}/moderate', [App\Http\Controllers\Admin\ReviewAnalysisController::class, 'moderate'])->name('reviews.moderate');

    // Seller Performance
    Route::get('seller-performance', [SellerPerformanceController::class, 'index'])->name('seller-performance');
});

require __DIR__.'/auth.php';
