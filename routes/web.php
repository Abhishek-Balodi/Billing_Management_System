<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('layout-horizontal');
// })->name('home');

// Route::get('/brands-list', function () {
//     return view('brands-list');
// });

Route::get('/sales', function () {
    return view('sales');
})->name('sales');

// Route::get('/purchase-list', function () {
//     return view('purchase-list');
// })->name('purchase-list');


// Route::get('/add-product', function () {
//     return view('add-product');
// });
// Route::View('/product-list','product-list');






// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('layout-horizontal');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::prefix('employees')->name('employees.')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::get('create', [EmployeeController::class, 'create'])->name('create');
    Route::post('store', [EmployeeController::class, 'store'])->name('store');
});

Route::prefix('employee')->group(function () {

    // Show login form
    Route::get('login', [EmployeeController::class, 'showLoginForm'])->name('employee.login');

    // Handle login
    Route::post('login', [EmployeeController::class, 'login'])->name('employee.login.submit');

    // Logout
    Route::post('logout', [EmployeeController::class, 'logout'])->name('employee.logout');
});

// routes/web.php
Route::middleware('auth:employee')->prefix('employee')->group(function () {
    Route::get('profile', [EmployeeController::class, 'editProfile'])->name('employee.profile.edit');
    Route::post('profile', [EmployeeController::class, 'updateProfile'])->name('employee.profile.update');
});


Route::middleware(['auth:web,employee'])->group(function() {


    Route::get('/', function () {
    return view('layout-horizontal');
    })->name('home');

    Route::get('/dashboard', function () {
    return view('layout-horizontal');
    })->middleware(['auth', 'verified'])->name('dashboard');

    // Category Routes
    Route::get('/category-list', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // SubCategory Routes
    Route::get('/sub-categories', [SubCategoryController::class, 'index'])->name('subcategories.index');
    Route::post('/subcategories', [SubCategoryController::class, 'store'])->name('subcategories.store');
    Route::put('/subcategories/{id}', [SubCategoryController::class, 'update'])->name('subcategories.update');
    Route::delete('/subcategories/{id}', [SubCategoryController::class, 'destroy'])->name('subcategories.destroy');

    // Brands Routes
    Route::get('/brands-list', [BrandController::class, 'index'])->name('brands.index');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::put('/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

    // Suppliers Routes
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    // Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{id}',[SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
    Route::get('/supplier-details/{id}', [SupplierController::class, 'show'])->name('suppliers.show');

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // Route::get('/add-product', [ProductController::class, 'index'])->name('products.index');
    Route::get('/product-list', [ProductController::class, 'index'])->name('products.index');
    Route::get('/add-product', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/product-details/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/categories_product', [CategoryController::class, 'productpage_store'])->name('categories.productpage_store');

    Route::get('/purchase', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchases/supplier/{id}', [PurchaseController::class, 'getSupplierData'])->name('purchases.supplier.data');

    Route::get('/purchase-list', [PurchaseController::class, 'index'])->name('purchases.index');
    // Route::get('/purchases/{id}/details', [PurchaseController::class, 'showDetails'])->name('purchases.details');
    // Purchase routes
    Route::get('/purchases/{id}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
    Route::put('/purchases/{id}', [PurchaseController::class, 'update'])->name('purchases.update');
    Route::get('/purchases/{id}/details', [PurchaseController::class, 'showDetails'])->name('purchases.details');
    Route::delete('/purchases/{id}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');
});

require __DIR__.'/auth.php';
