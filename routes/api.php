<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'createUser']);
Route::post('login', [AuthController::class, 'loginUser']);

// Public (no auth) ---------------------------
Route::get('products',             [ProductController::class, 'index']);
Route::get('products/{product}',   [ProductController::class, 'show']);

Route::get('categories',           [CategoryController::class, 'index']);
Route::get('categories/{category}',[CategoryController::class, 'show']);


// Protected (auth:sanctum) -------------------
Route::middleware('auth:sanctum')->group(function () {

    // Products
    Route::post   ('products',            [ProductController::class, 'store']);
    Route::put    ('products/{product}',  [ProductController::class, 'update']);
    Route::delete ('products/{product}',  [ProductController::class, 'destroy']);

    // Categories
    Route::post   ('categories',              [CategoryController::class, 'store']);
    Route::put    ('categories/{category}',   [CategoryController::class, 'update']);
    Route::delete ('categories/{category}',   [CategoryController::class, 'destroy']);
});