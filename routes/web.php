<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\OrderItemController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\WishlistController;
use App\Http\Controllers\AuthController;

// Client Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product Routes
Route::get('/products', [ClientProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{category}', [ClientProductController::class, 'category'])->name('products.category');
Route::get('/products/brand/{brand}', [ClientProductController::class, 'brand'])->name('products.brand');
Route::get('/products/{product}', [ClientProductController::class, 'show'])->name('products.show');
Route::get('/search', [ClientProductController::class, 'search'])->name('products.search');

// Wishlist Public Route
Route::get('/wishlist', [WishlistController::class, 'show'])->name('wishlist.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply-coupon');

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');
Route::post('/orders', [CheckoutController::class, 'store'])->name('orders.store')->middleware('auth');

// Order Routes (Protected by auth middleware)
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show')->middleware('auth');
Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel')->middleware('auth');

// Account Routes (Protected by auth middleware)
Route::prefix('account')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AccountController::class, 'dashboard'])->name('account.dashboard');
    Route::get('/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::post('/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::get('/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Route::post('/addresses', [AccountController::class, 'updateAddresses'])->name('account.addresses.update');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('account.wishlist');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{wishlistItem}', [WishlistController::class, 'remove'])->name('wishlist.remove');
});

// Order Confirmation (Public but requires order ID)
Route::get('/orders/{order}/confirmation', [OrderController::class, 'confirmation'])->name('orders.confirmation');

// Auth Routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Admin Routes (Protected by auth middleware)
Route::prefix('ad')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Brands
    Route::resource('brands', BrandController::class);

    // Products
    Route::resource('products', ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);

    // Users (Protected by admin middleware)
    Route::resource('users', UserController::class)->middleware('admin');

    // Customers
    Route::resource('customers', CustomerController::class);

    // Orders
    Route::resource('orders', AdminOrderController::class);

    // Order Items
    Route::resource('order-items', OrderItemController::class);

    // Banners
    Route::resource('banners', BannerController::class);
});
