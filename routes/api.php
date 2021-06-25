<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BidController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\Api\CategoryController;

Route::post('login', [\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'store']);
Route::post('register', [\Laravel\Fortify\Http\Controllers\RegisteredUserController::class, 'store']);
Route::post('logout', [\Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function() {
    Route::get('user', [UserController::class, 'show']);

    Route::post('bookmarks/{product}', [BookmarkController::class, 'store']);
    Route::delete('bookmarks/{product}', [BookmarkController::class, 'destroy']);

    Route::post('products/{product}/bids', [BidController::class, 'store']);
    Route::post('products/{product}/order', [OrderController::class, 'store']);

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('bids', [UserController::class, 'getBiddingHistory']);
        Route::get('wins', [UserController::class, 'getWonAuctions']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('bookmarks', [UserController::class, 'getBookmarks']);
        Route::put('password', [\Laravel\Fortify\Http\Controllers\PasswordController::class, 'update']);
        // Route::put('profile-information', [\Laravel\Fortify\Http\Controllers\ProfileInformationController::class, 'update']);
        Route::put('profile-information', [UserController::class, 'update']);
    });
});

Route::get('pages', [PageController::class, 'index']);
Route::get('pages/{page:slug}', [PageController::class, 'show']);

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

Route::get('products/search', [ProductController::class, 'search']);
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product:slug}', [ProductController::class, 'show']);
Route::get('products/{product}/bids', [ProductController::class, 'bids']);