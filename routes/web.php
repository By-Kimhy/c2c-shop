<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\KhqrController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ComfirmController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\RegisterController;
use App\Http\Controllers\Frontend\LoginController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ProductDetailController;
use App\Http\Controllers\Frontend\TrackingController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\SellerAccountController;
use App\Http\Controllers\Frontend\SellerProductController;
use App\Http\Controllers\Frontend\SellerOrderController;
use App\Http\Controllers\Frontend\AuthController as FrontendAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\ForgotPasswordController;
use App\Http\Controllers\Frontend\ResetPasswordController;


use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\SellerProfileController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\BProductController;
use App\Http\Controllers\Backend\PaymentController as BackendPaymentController;
use App\Http\Controllers\Backend\AuthController as BackendAuthController;





/*
|---------------------------------------------------------
| Frontend routes
|---------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
// product detail route with {id} parameter
Route::get('/productDetail', [ProductDetailController::class, 'index'])->name('product.detail'); // keep existing link
Route::get('/product/{id}', [ProductDetailController::class, 'show'])->name('product.show');
// Cart routes (clear names)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Contact page (show & process)
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');


// // Registration
// Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('frontend.register');
// Route::post('/register', [RegisterController::class, 'register'])->name('frontend.register.post');

// // Login
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('frontend.login');
// Route::post('/login', [LoginController::class, 'login'])->name('frontend.login.post');
// // add this alias so Laravel's default redirect('login') works
// Route::get('/login', function () {
//     return app()->call([LoginController::class, 'showLoginForm']);
// })->name('login');

// Route::post('/login', function () {
//     return app()->call([LoginController::class, 'login']);
// })->name('login.post');

// // Logout
// Route::post('/logout', [LoginController::class, 'logout'])->name('frontend.logout');

// // Show notice to verify (if logged in but not verified)
// Route::get('/email/verify', function () {
//     return view('frontend.auth.verify-notice');
// })->middleware('auth')->name('verification.notice');

// // Verification link (signed)
// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
//     return redirect()->intended('/')->with('success', 'Your email has been verified.');
// })->middleware(['auth', 'signed'])->name('verification.verify');

// // Resend verification email
// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
//     return back()->with('success', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// Route::get('password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


/*
|-------------------------
| Frontend auth (use 'login' name so middleware works)
|-------------------------
*/

// Registration
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
// Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register'); // optional: you can keep frontend.register if you want
// Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Login (make sure name is 'login' so default middleware redirectTo() works)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('frontend.login');          // <--- frontend.login
// Route::post('/login', [LoginController::class, 'login'])->name('frontend.login.post');         // <--- frontend.login.post

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('frontend.logout');
// Logout
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Email verification flow (frontend)
Route::get('/email/verify', function () {
    return view('frontend.auth.verify-notice');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->intended('/')->with('success', 'Your email has been verified.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

// Password reset (frontend)
Route::get('password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');








Route::get('/comfirm', [ComfirmController::class, 'index'])->name('comfirm');
Route::get('/product', [ProductController::class, 'index'])->name('product');
Route::get('/productDetail', [ProductDetailController::class, 'index'])->name('productDetail');

Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

/*
|---------------------------------------------------------
| Backend (admin) routes
|---------------------------------------------------------
*/

// ------------------------------
// Admin Authentication (NO middleware)
// ------------------------------
Route::get('admin/login', [BackendAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [BackendAuthController::class, 'login'])->name('admin.login.post');
Route::post('admin/logout', [BackendAuthController::class, 'logout'])->name('admin.logout');

// ------------------------------
// Admin Panel (PROTECTED)
// ------------------------------
Route::prefix('admin')->name('admin.')
    ->middleware(['web', \App\Http\Middleware\AdminMiddleware::class, 'auth'])
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
    ->middleware(['web', 'auth'])
    ->group(function () {

        // seller routes (inside the existing seller group)
        Route::get('orders/{id}', [SellerOrderController::class, 'show'])->name('orders.show');

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

// KHQR endpoints (non-checkout controller helpers — rename to avoid collisions)
Route::get('/checkout/khqr/{order}', [KhqrController::class, 'showByOrder'])->name('khqr.showByOrder');
Route::get('/checkout/khqr/status/{order}', [KhqrController::class, 'statusByOrder'])->name('khqr.statusByOrder');
Route::post('/webhook/khqr', [KhqrController::class, 'webhook'])->name('webhook.khqr');
// web.php (POST)
Route::post('/khqr/check-md5', [KhqrController::class, 'checkTransactionByMD5'])
    ->name('khqr.check_md5');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/{order}/khqr', [CheckoutController::class, 'showKhqr'])->name('checkout.khqr.show');

// KHQR helper endpoints (POST for actions)
Route::post('/khqr/generate', [KhqrController::class, 'generateQrCode'])->name('khqr.generate'); // optional: create QR by amount/order
Route::post('/khqr/check-md5', [KhqrController::class, 'checkMd5'])->name('khqr.check_md5');     // used by "Check payment" button




// small helpers you used:
// Route::post('/generate-qrcode', [KhqrController::class, 'generateQrCode']);
// Route::post('/checkQRCode', [KhqrController::class, 'checkTransactionByMD5']);
// Route::post('/checkout/khqr/create', [KhqrController::class, 'generateQrCode'])->name('checkout.khqr.create');
// Route::post('/khqr/generate/{order}', [KhqrController::class, 'generateQrFromOrder']);


// Route::get('/generate-qrcode', [KhqrController::class, 'generateQrCode']);
// Route::get('/checkQRCode', [KhqrController::class, 'checkTransactionByMD5']);
