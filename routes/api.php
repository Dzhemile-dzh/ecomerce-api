<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;

// 1. Public read‐only
Route::get('products',              [ProductController::class, 'index']);
Route::get('products/{product}',    [ProductController::class, 'show']);
Route::get('categories',            [ProductController::class, 'index']);
Route::get('categories/{category}', [ProductController::class, 'show']);


// 2. Protected create/update/delete
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('categories', CategoryController::class)
         ->except(['index','show']);
    Route::apiResource('products',   ProductController::class)
         ->except(['index','show']);
});
