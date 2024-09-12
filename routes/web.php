<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CapacityController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\RamController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ModelNumberController;
use App\Http\Controllers\LockStatusController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AuctionSlotController;
use App\Http\Controllers\ModelNameController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ClientsFeedbackController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordChanged;

Auth::routes();

Route::get('/', function () {
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


// Admin Routes
Route::middleware('admin')->prefix('admin')->group(function () {
    // Route::prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('admin');
    ;

    // Colors
    Route::get('/colors', [ColorController::class, 'index'])->name('colors.index');
    Route::post('/colors', [ColorController::class, 'store'])->name('colors.store');
    Route::get('/colors/{color}/edit', [ColorController::class, 'edit'])->name('colors.edit');
    Route::put('/colors/{color}', [ColorController::class, 'update'])->name('colors.update');
    Route::delete('/colors/{color}', [ColorController::class, 'destroy'])->name('colors.destroy');

    // Capacity
    Route::resource('capacities', CapacityController::class);

    // Auction slots
    Route::resource('auction_slots', AuctionSlotController::class);

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

    // SubCategory
    Route::get('subcategories', [SubcategoryController::class, 'index'])->name('subcategories.index');
    Route::post('subcategories', [SubcategoryController::class, 'store'])->name('subcategories.store');
    Route::get('subcategories/{subcategory}/edit', [SubcategoryController::class, 'edit'])->name('subcategories.edit');
    Route::put('subcategories/{subcategory}', [SubcategoryController::class, 'update'])->name('subcategories.update');
    Route::delete('subcategories/{subcategory}', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');

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
    Route::get('products/add', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/products/feature-toggle', [ProductController::class, 'toggleFeatured'])->name('products.feature-toggle');

    // Subcategories related to category
    Route::get('subcategories/by_category', [SubcategoryController::class, 'getByCategory'])->name('subcategories.by_category');

    // Manufacturers Relations
    Route::get('get/ManufacturersRelations/{id}', [ProductController::class, 'getManufacturersRelations'])->name('get.manufacturers.relations');

    // Model Relations
    Route::get('get/ModelRelations/{id}', [ProductController::class, 'getModelRelations'])->name('get.model.relations');

    // Model Relations
    Route::get('all-bids', [BidController::class, 'index'])->name('bids.index');

    // User Management
    Route::get('users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('users/{product}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('users/{product}', [UserManagementController::class, 'update'])->name('users.update');
    // Route::post('users', [UserManagementController::class, 'store'])->name('users.store');
    // Route::delete('users/{product}', [UserManagementController::class, 'destroy'])->name('users.destroy');

    // Ram
    Route::get('rams', [RamController::class, 'index'])->name('rams.index');
    Route::post('rams', [RamController::class, 'store'])->name('rams.store');
    Route::get('rams/{ram}/edit', [RamController::class, 'edit'])->name('rams.edit');
    Route::put('rams/{ram}', [RamController::class, 'update'])->name('rams.update');
    Route::delete('rams/{ram}', [RamController::class, 'destroy'])->name('rams.destroy');

    // Size
    Route::get('sizes', [SizeController::class, 'index'])->name('sizes.index');
    Route::post('sizes', [SizeController::class, 'store'])->name('sizes.store');
    Route::get('sizes/{size}/edit', [SizeController::class, 'edit'])->name('sizes.edit');
    Route::put('sizes/{size}', [SizeController::class, 'update'])->name('sizes.update');
    Route::delete('sizes/{size}', [SizeController::class, 'destroy'])->name('sizes.destroy');

    // ModelName
    Route::get('model-names', [ModelNameController::class, 'index'])->name('modelNames.index');
    Route::post('model-names', [ModelNameController::class, 'store'])->name('modelNames.store');
    Route::get('model-names/{modelName}/edit', [ModelNameController::class, 'edit'])->name('modelNames.edit');
    Route::put('model-names/{modelName}', [ModelNameController::class, 'update'])->name('modelNames.update');
    Route::delete('model-names/{modelName}', [ModelNameController::class, 'destroy'])->name('modelNames.destroy');

    Route::prefix('news')->group(function () {
        Route::get('/', [NewsController::class, 'index'])->name('news.index');
        Route::post('/', [NewsController::class, 'store'])->name('news.store');
        Route::get('/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::put('/{news}', [NewsController::class, 'update'])->name('news.update');
        Route::delete('/{news}', [NewsController::class, 'destroy'])->name('news.destroy');
    });

    Route::prefix('clients-feedback')->group(function () {
        Route::get('/', [ClientsFeedbackController::class, 'index'])->name('clients.feedback.index');
        Route::post('/store', [ClientsFeedbackController::class, 'store'])->name('clients.feedback.store');
        Route::get('/{feedback}/edit', [ClientsFeedbackController::class, 'edit'])->name('clients.feedback.edit');
        Route::put('/update/{feedback}', [ClientsFeedbackController::class, 'update'])->name('clients.feedback.update');
        Route::delete('/destroy/{feedback}', [ClientsFeedbackController::class, 'destroy'])->name('clients.feedback.destroy');
    });

    Route::get('/test-password-changed-email', function () {
        $user = (object) [
            'email' => 'alinaqvif@gmail.com',
            'name' => 'Test User'
        ];

        try {
            Mail::to($user->email)->send(new PasswordChanged($user->name));
            return 'Email sent to ' . $user->email;
        } catch (\Exception $e) {
            return 'Failed to send email: ' . $e->getMessage();
        }
    });

    // Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('update.password');
});
