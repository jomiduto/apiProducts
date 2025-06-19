<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ProductPriceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::apiResource('products', ProductController::class);
Route::get('products/{id}/prices', [ProductPriceController::class, 'index']);
Route::post('products/{id}/prices', [ProductPriceController::class, 'store']);
Route::apiResource('currencies', CurrencyController::class);

