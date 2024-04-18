<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\RegisterApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Product
Route::post('/products', [ProductApiController::class, 'store'])->name('products.store');
Route::get('/products', [ProductApiController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductApiController::class, 'show'])->name('products.show');
Route::put('/products/{product}', [ProductApiController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductApiController::class, 'destroy'])->name('products.destroy');

// Register new user
Route::post('/register', [RegisterApiController::class, 'register']);