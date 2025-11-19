<?php

use App\Http\Controllers\Frontend\CatalogController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\KhqrController;
use App\Http\Controllers\Backend\ProductController as BackendProductController;
use App\Http\Controllers\Backend\CategoryController as BackendCategoryController;

Route::get('/', [CatalogController::class,'index'])->name('home');
Route::get('/catalog', [CatalogController::class,'index'])->name('catalog');
Route::get('/products/{slug}', [ProductController::class,'show'])->name('products.show');

// cart
Route::get('/cart', [CartController::class,'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class,'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class,'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class,'remove'])->name('cart.remove');

// checkout
Route::get('/checkout', [CheckoutController::class,'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class,'process'])->name('checkout.process');

// khqr payment
Route::get('/khqr/{order_number}', [KhqrController::class,'show'])->name('khqr.show');
Route::post('/payment/khqr/callback', [KhqrController::class,'callback'])->name('khqr.callback');

// Backend (admin/seller)
Route::middleware(['auth','verified','can:access-backend'])->prefix('admin')->name('backend.')->group(function(){
    Route::resource('products', BackendProductController::class);
    Route::resource('categories', BackendCategoryController::class);
    // orders...
});