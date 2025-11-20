<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\CartController;


// 1. HOME PAGE
Route::get('/', [HomeController::class, 'index'])->name('Home'); 

// 2. PRODUCT DETAIL PAGE
Route::get('/product/{id}', [HomeController::class, 'show'])->middleware('auth')->name('product.show');


// 3. DASHBOARD USER BIASA
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// 4. PROFILE ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeItem'])->name('cart.remove');
    Route::patch('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.update');
});


// 5. ADMIN ROUTES
Route::middleware(['auth', 'auth.admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
    Route::get('/users/{id}/products', [UserController::class, 'showSellerProducts'])->name('admin.users.products');
});


// 6. SELLER ROUTES
Route::middleware(['auth', 'auth.seller'])->prefix('seller')->group(function () {   
    Route::get('/dashboard', [ProductController::class, 'index'])->name('seller.dashboard');
    Route::post('/products', [ProductController::class, 'store'])->name('seller.products.store');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('seller.products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('seller.products.destroy');

});

require __DIR__.'/auth.php';