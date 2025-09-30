<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PurchaseController;

// ========================
// 🔹 Auth Routes
// ========================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========================
// 🔹 Produk (Public)
// ========================
Route::get('/', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk/{id}/buy', [ProdukController::class, 'showBuyForm'])->name('produk.buy');
Route::post('/produk/{id}/buy', [ProdukController::class, 'processPurchase'])->name('produk.purchase');
Route::get('/produk/{id}/direct-checkout', [ProdukController::class, 'directCheckout'])->name('produk.directCheckout');
Route::post('/produk/{id}/process-direct', [ProdukController::class, 'processDirectPurchase'])->name('produk.processDirectPurchase');

// ========================
// 🔹 User (Auth Required)
// ========================
Route::middleware(['auth'])->group(function () {

    // Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/checkout', [CartController::class, 'processCheckout'])->name('cart.processCheckout');

    // 🔹 FIX: Riwayat pembelian user - pindahkan ke PurchaseController
    Route::get('/my-purchases', [PurchaseController::class, 'myPurchases'])->name('purchase.purchases');
});

// ========================
// 🔹 Admin Only
// ========================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Produk CRUD
    Route::get('/produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    // 🔹 FIX: Riwayat pembelian admin (semua transaksi)
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::put('/purchases/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
});