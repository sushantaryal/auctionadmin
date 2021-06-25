<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class)->except(['create', 'show']);

    Route::get('products/{product}/replicate', [ProductController::class, 'replicate'])->name('products.replicate');
    Route::post('products/photos/{photo}', [ProductController::class, 'destroyPhoto'])->name('products.photo.destroy');
    Route::resource('products', ProductController::class)->except(['show']);

    // Pages
    Route::get('pages/published/{page}', [PageController::class, 'published'])->name('pages.published');
    Route::resource('pages', PageController::class)->except(['show']);

    // orders
    Route::resource('orders', OrderController::class)->only(['index', 'edit', 'update']);

    // Users
    Route::resource('users', UserController::class)->except(['show']);

    // Profile
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
    Route::get('change-password', [ProfileController::class, 'changePassword'])->name('change-password');

});
