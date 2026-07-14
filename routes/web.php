<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\PlatformDailySummaryController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Role: Penjual (Seller)
Route::middleware(['auth', 'role:penjual'])->prefix('seller')->name('seller.')->group(function () {
    Route::resource('toko', TokoController::class);
    Route::resource('produk', ProdukController::class);
    Route::resource('orders', SellerOrderController::class)->only(['index', 'show', 'update']);
    Route::resource('toko-summary', App\Http\Controllers\Seller\TokoDailySummaryController::class);
});

use App\Http\Controllers\ReviewController;

// Role: Pembeli (Buyer)
Route::middleware(['auth', 'role:pembeli'])->prefix('buyer')->name('buyer.')->group(function () {
    Route::resource('cart', CartController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('payments', PaymentController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('wishlist', WishlistController::class);
    Route::resource('reviews', ReviewController::class);
});

// Role: Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('platform-summary', PlatformDailySummaryController::class);
});

require __DIR__.'/auth.php';
