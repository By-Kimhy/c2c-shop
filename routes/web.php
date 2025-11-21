<?php
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\frontend\CheckOutController;
use App\Http\Controllers\frontend\ComfirmController;
use App\Http\Controllers\frontend\ContactController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\InvoiceController;
use App\Http\Controllers\frontend\LoginController;
use App\Http\Controllers\frontend\ProductController;
use App\Http\Controllers\frontend\ProductDetailController;
use App\Http\Controllers\frontend\SellController;
use App\Http\Controllers\frontend\TrackingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\SellerProfileController;



// Frontend Block
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});

Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart');
});

Route::controller(CheckOutController::class)->group(function () {
    Route::get('/checkout', 'index')->name('checkout');
});

Route::controller(ComfirmController::class)->group(function () {
    Route::get('/comfirm', 'index')->name('comfirm');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/product', 'index')->name('product');
});

Route::controller(ProductDetailController::class)->group(function () {
    Route::get('/productDetail', 'index')->name('productDetail');
});

Route::controller(SellController::class)->group(function () {
    Route::get('/sell', 'index')->name('sell');
});

Route::controller(TrackingController::class)->group(function () {
    Route::get('/tracking', 'index')->name('tracking');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login');
});


Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'index')->name('contact');
});

Route::get('/invoice', function () {
    return view('frontend.invoice'); // or use a controller if dynamic later
})->name('invoice');

Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

// -----------backend block----------------

// Admin dashboard
Route::get('/admin/dashboard', [App\Http\Controllers\Backend\DashboardController::class, 'index'])
    ->name('admin.dashboard');

// Orders index
Route::get('/admin/orders', [OrderController::class, 'index'])
    ->name('admin.orders.index');
// Order detail (you already added)
Route::get('/admin/orders/{id}', [OrderController::class, 'show'])
    ->name('admin.orders.show');
// Update order status (admin action)
// Route::post('/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])
//     ->name('admin.orders.update.status');
// temporary: accept GET and POST while debugging why a GET is fired
Route::match(['get', 'post'], '/admin/orders/{id}/status', [OrderController::class, 'updateStatus'])
    ->name('admin.orders.update.status');

// Users CRUD (creates route names like admin.users.index, admin.users.create, etc.)
Route::controller(UserController::class)
    ->prefix('admin/users')
    ->as('admin.users.')
    ->group(function () {
        Route::get('/', 'index')->name('index');           // admin.users.index
        Route::get('create', 'create')->name('create');    // admin.users.create
        Route::post('/', 'store')->name('store');          // admin.users.store
        Route::get('{id}', 'show')->name('show');         // admin.users.show
        Route::get('{id}/edit', 'edit')->name('edit');    // admin.users.edit
        Route::put('{id}', 'update')->name('update');     // admin.users.update
        Route::delete('{id}', 'destroy')->name('destroy'); // admin.users.destroy
    });

// Admin seller profiles
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('seller-profiles', [SellerProfileController::class, 'index'])->name('seller-profiles.index');
    Route::get('seller-profiles/{id}/edit', [SellerProfileController::class, 'edit'])->name('seller-profiles.edit');
    Route::put('seller-profiles/{id}', [SellerProfileController::class, 'update'])->name('seller-profiles.update');
    Route::delete('seller-profiles/{id}', [SellerProfileController::class, 'destroy'])->name('seller-profiles.destroy');
});
// Placeholder routes (C2C Shop Basic)
// Route::view('/admin/users', 'backend.placeholders.users')->name('admin.users.index');
// Route::view('/admin/sellers', 'backend.placeholders.sellers')->name('admin.sellers.index');
Route::view('/admin/categories', 'backend.placeholders.categories')->name('admin.categories.index');
Route::view('/admin/products', 'backend.placeholders.products')->name('admin.products.index');
Route::view('/admin/payments', 'backend.placeholders.payments')->name('admin.payments.index');
