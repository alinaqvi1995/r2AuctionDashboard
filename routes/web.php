<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CapacityController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ModelNumberController;
use App\Http\Controllers\LockStatusController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    // return view('login');
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.pages.index');
    })->name('dashboard');
});

// Colors
Route::get('/colors', [ColorController::class, 'index'])->name('colors.index');
Route::post('/colors', [ColorController::class, 'store'])->name('colors.store');
Route::get('/colors/{color}/edit', [ColorController::class, 'edit']);
Route::put('/colors/{color}', [ColorController::class, 'update'])->name('colors.update');
Route::delete('/colors/{color}', [ColorController::class, 'destroy'])->name('colors.destroy');

// Capacity
Route::resource('capacities', CapacityController::class);

// Manufacturer
Route::get('manufacturers', [ManufacturerController::class, 'index'])->name('manufacturers.index');
Route::post('manufacturers', [ManufacturerController::class, 'store'])->name('manufacturers.store');
Route::get('manufacturers/{manufacturer}/edit', [ManufacturerController::class, 'edit'])->name('manufacturers.edit');
Route::put('manufacturers/{manufacturer}', [ManufacturerController::class, 'update'])->name('manufacturers.update');
Route::delete('manufacturers/{manufacturer}', [ManufacturerController::class, 'destroy'])->name('manufacturers.destroy');

// Category
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

// Grade
Route::get('grades', [GradeController::class, 'index'])->name('grades.index');
Route::post('grades', [GradeController::class, 'store'])->name('grades.store');
Route::get('grades/{grade}/edit', [GradeController::class, 'edit'])->name('grades.edit');
Route::put('grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
Route::delete('grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');

// Carrier
Route::get('carriers', [CarrierController::class, 'index'])->name('carriers.index');
Route::post('carriers', [CarrierController::class, 'store'])->name('carriers.store');
Route::get('carriers/{carrier}/edit', [CarrierController::class, 'edit'])->name('carriers.edit');
Route::put('carriers/{carrier}', [CarrierController::class, 'update'])->name('carriers.update');
Route::delete('carriers/{carrier}', [CarrierController::class, 'destroy'])->name('carriers.destroy');

// Region
Route::get('regions', [RegionController::class, 'index'])->name('regions.index');
Route::post('regions', [RegionController::class, 'store'])->name('regions.store');
Route::get('regions/{region}/edit', [RegionController::class, 'edit'])->name('regions.edit');
Route::put('regions/{region}', [RegionController::class, 'update'])->name('regions.update');
Route::delete('regions/{region}', [RegionController::class, 'destroy'])->name('regions.destroy');

// Model Numbers
Route::get('model_numbers', [ModelNumberController::class, 'index'])->name('modelnumbers.index');
Route::post('model_numbers', [ModelNumberController::class, 'store'])->name('modelnumbers.store');
Route::get('model_numbers/{modelnumber}/edit', [ModelNumberController::class, 'edit'])->name('modelnumbers.edit');
Route::put('model_numbers/{modelnumber}', [ModelNumberController::class, 'update'])->name('modelnumbers.update');
Route::delete('model_numbers/{modelnumber}', [ModelNumberController::class, 'destroy'])->name('modelnumbers.destroy');

// Model Numbers
Route::get('lock_statuses', [LockStatusController::class, 'index'])->name('lockstatuses.index');
Route::post('lock_statuses', [LockStatusController::class, 'store'])->name('lockstatuses.store');
Route::get('lock_statuses/{lockStatus}/edit', [LockStatusController::class, 'edit'])->name('lockstatuses.edit');
Route::put('lock_statuses/{lockStatus}', [LockStatusController::class, 'update'])->name('lockstatuses.update');
Route::delete('lock_statuses/{lockStatus}', [LockStatusController::class, 'destroy'])->name('lockstatuses.destroy');

// Products
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::post('products', [ProductController::class, 'store'])->name('products.store');
Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
