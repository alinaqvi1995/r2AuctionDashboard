<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\RegisterApiController;
use App\Http\Controllers\Api\LoginApiController;
use App\Http\Controllers\Api\SocialLoginController;
use App\Http\Controllers\Api\ManufacturerApiController;
use App\Http\Controllers\Api\CapacityApiController;
use App\Http\Controllers\Api\ColorApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\SellerDashboardApiController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\WishListController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Api\BuyerDashboardController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\AuthController;

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
Route::post('/products', [ProductApiController::class, 'store']);
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{product}', [ProductApiController::class, 'show']);
Route::post('/products/{product}', [ProductApiController::class, 'update']);
Route::delete('/products/{product}', [ProductApiController::class, 'destroy']);
Route::post('/products_filter', [ProductApiController::class, 'filter']);
Route::get('/sellerProducts/{id}', [ProductApiController::class, 'sellerProducts']);
Route::get('/get_product_subjects', [ProductApiController::class, 'getProSubjects']);
Route::post('/products-status-toggle', [ProductApiController::class, 'toggleStatus']);

// Register new user
Route::post('/register', [RegisterApiController::class, 'register']);
Route::post('/update/{user}', [RegisterApiController::class, 'update']);

// Login new user
Route::post('/login', [LoginApiController::class, 'login']);

// Social logins
Route::get('/login/{provider}', [SocialLoginController::class, 'redirectToProvider']);
Route::get('/login/{provider}/callback', [SocialLoginController::class, 'handleProviderCallback']);

// manufacturers
Route::get('/manufacturers', [ManufacturerApiController::class, 'index']);
Route::get('/manufacturers/{manufacturer}', [ManufacturerApiController::class, 'show']);

// capacities
Route::get('/capacities', [CapacityApiController::class, 'index']);
Route::get('/capacities/{capacity}', [CapacityApiController::class, 'show']);

// colors
Route::get('/colors', [ColorApiController::class, 'index']);
Route::get('/colors/{color}', [ColorApiController::class, 'show']);

// user
Route::prefix('users')->group(function () {
    Route::get('/', [UserApiController::class, 'index']);
    Route::get('/{id}', [UserApiController::class, 'show']);
    Route::post('/', [UserApiController::class, 'store']);
    Route::post('/{id}', [UserApiController::class, 'update']);
    Route::delete('/{id}', [UserApiController::class, 'destroy']);
});

// user
Route::prefix('orders')->group(function () {
    // Route::get('/', [UserApiController::class, 'index']);
    // Route::get('/{id}', [UserApiController::class, 'show']);
    Route::post('/', [OrderController::class, 'store']);
    // Route::post('/{id}', [UserApiController::class, 'update']);
    // Route::delete('/{id}', [UserApiController::class, 'destroy']);
});

// user
Route::prefix('bids')->group(function () {
    Route::post('/', [BidController::class, 'store']);
    Route::get('/cancel/{productId}', [BidController::class, 'cancelBids']);
    Route::get('/accept/{bidId}', [BidController::class, 'acceptBid']);
});

// Manufacturers Relations
Route::get('get/ManufacturersRelations/{id}', [ProductController::class, 'getManufacturersRelations']);

// Model Relations
Route::get('get/ModelRelations/{id}', [ProductController::class, 'getModelRelations']);

// WishList
Route::post('add_to_wishlist', [WishListController::class, 'store']);

// my wishlist
Route::get('/wishlist/{id}', [BuyerDashboardController::class, 'wishlist_products']);

// seller
Route::prefix('seller')->group(function () {
    Route::get('/{id}', [SellerDashboardApiController::class, 'dashboard']);
    Route::get('/bid_products/{id}', [SellerDashboardApiController::class, 'bid_products']);
    Route::get('/my_sales/{user_id}', [SellerDashboardApiController::class, 'mySales']);
    Route::post('/orders/filter/{seller_id}', [OrderController::class, 'filterOrders']);
});

Route::get('/buyerProducts', [BuyerDashboardController::class, 'buyer_dashboard_products']);

// buyer
Route::prefix('buyer')->group(function () {
    Route::get('/{id}', [BuyerDashboardController::class, 'dashboard']);
    Route::get('/bid_products/{id}', [BuyerDashboardController::class, 'buyer_bid_products']);
    Route::get('/my_orders/{id}', [BuyerDashboardController::class, 'myOrders']);
});

Route::get('/home_page', [HomeController::class, 'homePage']);

Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);

Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);