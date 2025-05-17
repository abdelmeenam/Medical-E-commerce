<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\CheckoutController;


Route::get('/', [ProductController::class, 'index'])->name('shop.home');
Route::get('/products', [ProductController::class, 'index'])->name('shop.products');


Route::resource('cart', CartController::class);
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/order/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
