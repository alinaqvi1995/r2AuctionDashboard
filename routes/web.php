<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SubVendorController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\Vendor\BlogController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/unauthorized', function () {
    return view('unauthorized');
})->name('unauthorized');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


// Admin Routes
Route::middleware('admin')->prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('admin');

    // Roles Crud
    Route::resource('roles', RoleController::class);

    // Permissions Crud
    Route::resource('permissions', PermissionsController::class);

    // RolesPermissions Crud
    Route::resource('role_permissions', RolePermissionController::class);
    Route::post('/get_permissions', [RolePermissionController::class, 'getPermissions'])->name('get_permissions_by_role');

    // Packages Crud
    Route::resource('packages', PackageController::class);

    // Categories Crud
    Route::resource('categories', CategoryController::class);

    // Products Crud
    Route::resource('products', ProductController::class);

    // Events Crud
    Route::resource('events', EventController::class);

    // Subcategories Crud
    Route::resource('subcategories', SubcategoryController::class);

    // Tickets Crud
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    
    // get categories
    Route::get('/get-categories/{packageId}', [EventController::class, 'getCategories'])->name('get.categories');
    
    // get subcategories
    Route::get('/get-subcategories/{categoryId}', [ProductController::class, 'getsubCategories'])->name('get.subcategories');
    
    // user management
    Route::get('/users', [UserManagementController::class, 'indexUser'])->name('users.index');
    Route::get('/users/new', [UserManagementController::class, 'createUser'])->name('users.add');
    Route::post('/users/register', [UserManagementController::class, 'register'])->name('users.register');
    Route::get('/vendor-categories', [UserManagementController::class, 'getCategories'])->name('users.get.categories');

    //blogs
    Route::resource('blogs', BlogsController::class);
});


// Vendor Routes
Route::middleware('vendor')->prefix('vendor')->group(function () {

    Route::get('/', [VendorController::class, 'index'])->name('vendor');

    // products
    Route::get('/products', [VendorController::class, 'indexProduct'])->name('vendor.products');
    Route::get('/products/edit/{id}', [VendorController::class, 'editProduct'])->name('vendor.products.edit');
    Route::post('/products/store', [VendorController::class, 'storeProduct'])->name('vendor.products.store');
    Route::put('/products/update/', [VendorController::class, 'updateProduct'])->name('vendor.products.update');

    // events
    Route::get('/events', [VendorController::class, 'indexEvent'])->name('vendor.events');
    Route::get('/events/edit/{event}', [VendorController::class, 'editEvent'])->name('vendor.events.edit');
    Route::post('/events/store', [VendorController::class, 'storeEvent'])->name('vendor.events.store');
    Route::put('/events/update/{event}', [VendorController::class, 'updateEvent'])->name('vendor.events.update');
    
    // get subcategories
    Route::get('/get-subcategory/{categoryId}', [ProductController::class, 'getsubCategories'])->name('vendor.get.subcategories');
    
    //blogs
    Route::get('/blogs', [BlogController::class, 'index'])->name('vendor.blogs.index');
    Route::get('/blogs/add', [BlogController::class, 'create'])->name('vendor.blogs.create');
    Route::post('/blogs', [BlogController::class, 'store'])->name('vendor.blogs.store');
    Route::get('/blogs/{blog}/edit', [BlogController::class, 'edit'])->name('vendor.blogs.edit');
    Route::put('/blogs/{blog}', [BlogController::class, 'update'])->name('vendor.blogs.update');
    Route::delete('/blogs/{blog}', [BlogController::class, 'destroy'])->name('vendor.blogs.destroy');
});


// SubVendor Routes
Route::middleware('subVendor')->prefix('subVendor')->group(function () {

    Route::get('/', [SubVendorController::class, 'index'])->name('subVendor');

    // products
    Route::get('/my_products', [SubVendorController::class, 'indexProducts'])->name('subVendor.products');
    Route::get('/my_products/edit/{id}', [SubVendorController::class, 'editProducts'])->name('subVendor.products.edit');
    Route::post('/my_products/store', [SubVendorController::class, 'storeProducts'])->name('subVendor.products.store');
    Route::put('/my_products/update/', [SubVendorController::class, 'updateProducts'])->name('subVendor.products.update');

    // events
    Route::get('/my_events', [SubVendorController::class, 'indexEvents'])->name('subVendor.events');
    Route::get('/my_events/edit/{event}', [SubVendorController::class, 'editEvents'])->name('subVendor.events.edit');
    Route::post('/my_events/store', [SubVendorController::class, 'storeEvents'])->name('subVendor.events.store');
    Route::put('/my_events/update/{event}', [SubVendorController::class, 'updateEvents'])->name('subVendor.events.update');

    // blogs
    // Route::get('/my_events', [SubVendorController::class, 'indexEvents'])->name('subVendor.events');
    // Route::get('/my_events/edit/{event}', [SubVendorController::class, 'editEvents'])->name('subVendor.events.edit');
    // Route::post('/my_events/store', [SubVendorController::class, 'storeEvents'])->name('subVendor.events.store');
    // Route::put('/my_events/update/{event}', [SubVendorController::class, 'updateEvents'])->name('subVendor.events.update');

});