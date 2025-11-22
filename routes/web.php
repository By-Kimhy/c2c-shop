<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckOutController;
use App\Http\Controllers\Frontend\ComfirmController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\InvoiceController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProductDetailController;
use App\Http\Controllers\Frontend\SellController;
use App\Http\Controllers\Frontend\TrackingController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\SellerAccountController;
use App\Http\Controllers\Frontend\SellerProductController;

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\SellerProfileController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\BProductController;
use App\Http\Controllers\Backend\PaymentController as BackendPaymentController;
use App\Http\Controllers\Backend\AuthController;

/*
|---------------------------------------------------------
| Frontend routes
|---------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductDetailController::class, 'show'])->name('product.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/checkout', [CheckOutController::class, 'index'])->name('checkout');
Route::get('/comfirm', [ComfirmController::class, 'index'])->name('comfirm');
Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/productDetail', [ProductDetailController::class, 'index'])->name('productDetail');
Route::get('/sell', [SellController::class, 'index'])->name('sell');
Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/invoice', function () {
    return view('frontend.invoice');
})->name('invoice');

Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

/*
|---------------------------------------------------------
| Backend (admin) routes
|---------------------------------------------------------
*/

// ------------------------------
// Admin Authentication (NO middleware)
// ------------------------------

Route::get('admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// ------------------------------
// Admin Panel (PROTECTED)
// ------------------------------
Route::prefix('admin')->name('admin.')
     ->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    // Accept GET for debugging, but ideally change to POST in production
    Route::match(['get', 'post'], 'orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update.status');

    // Seller profiles
    Route::get('seller-profiles', [SellerProfileController::class, 'index'])->name('seller-profiles.index');
    Route::get('seller-profiles/{id}/edit', [SellerProfileController::class, 'edit'])->name('seller-profiles.edit');
    Route::put('seller-profiles/{id}', [SellerProfileController::class, 'update'])->name('seller-profiles.update');
    Route::delete('seller-profiles/{id}', [SellerProfileController::class, 'destroy'])->name('seller-profiles.destroy');

    
    // Users CRUD: admin.users.*
    Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('{id}', 'show')->name('show');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::put('{id}', 'update')->name('update');
        Route::delete('{id}', 'destroy')->name('destroy');
    });

    // Categories CRUD: admin.categories.*
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Products CRUD: admin.products.*
    Route::get('products', [BProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [BProductController::class, 'create'])->name('products.create');
    Route::post('products', [BProductController::class, 'store'])->name('products.store');
    Route::get('products/{id}', [BProductController::class, 'show'])->name('products.show');
    Route::get('products/{id}/edit', [BProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [BProductController::class, 'update'])->name('products.update');
    Route::delete('products/{id}', [BProductController::class, 'destroy'])->name('products.destroy');

    // Payments CRUD: admin.payments.*
    Route::get('payments', [BackendPaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{id}', [BackendPaymentController::class, 'show'])->name('payments.show');
    Route::match(['post', 'put'], 'payments/{id}/status', [BackendPaymentController::class, 'updateStatus'])->name('payments.update.status');
    Route::delete('payments/{id}', [BackendPaymentController::class, 'destroy'])->name('payments.destroy');

    // Fix missing seller profiles (button action)
    Route::post('seller-profiles/fix-missing', [SellerProfileController::class, 'fixMissing'])
        ->name('seller-profiles.fix-missing');


});



/*
|---------------------------------------------------------
| Seller (authenticated) routes
| - Merged into single group protected by auth + ensure.seller
| - Names use "seller." prefix (e.g. seller.dashboard, seller.products.index)
|---------------------------------------------------------
*/
Route::prefix('seller')
    ->name('seller.')
    ->group(function () {
        // seller account
        Route::get('dashboard', [SellerAccountController::class, 'dashboard'])->name('dashboard');
        Route::get('profile/edit', [SellerAccountController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [SellerAccountController::class, 'update'])->name('profile.update');

        // seller product management
        Route::get('products', [SellerProductController::class, 'index'])->name('products.index');
        Route::get('products/create', [SellerProductController::class, 'create'])->name('products.create');
        Route::post('products', [SellerProductController::class, 'store'])->name('products.store');
        Route::get('products/{id}', [SellerProductController::class, 'show'])->name('products.show');
        Route::get('products/{id}/edit', [SellerProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{id}', [SellerProductController::class, 'update'])->name('products.update');
        Route::delete('products/{id}', [SellerProductController::class, 'destroy'])->name('products.destroy');
    });
