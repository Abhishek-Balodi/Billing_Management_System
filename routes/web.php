<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SupplierController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('layout-horizontal');
})->name('home');

Route::get('/brands-list', function () {
    return view('brands-list');
});
// Route::get('/product-list', function () {
//     return view('product-list');
// });


// Route::get('/add-product', function () {
//     return view('add-product');
// });
// Route::View('/product-list','product-list');



// Route::get('/add-product', [ProductController::class, 'index'])->name('products.index');
Route::get('/product-list', [ProductController::class, 'index'])->name('products.index');
Route::get('/add-product', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/product-details/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::post('/categories_product', [CategoryController::class, 'productpage_store'])->name('categories.productpage_store');


Route::get('/category-list', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');


Route::get('/sub-categories', [SubCategoryController::class, 'index'])->name('subcategories.index');
Route::post('/subcategories', [SubCategoryController::class, 'store'])->name('subcategories.store');
Route::put('/subcategories/{id}', [SubCategoryController::class, 'update'])->name('subcategories.update');
Route::delete('/subcategories/{id}', [SubCategoryController::class, 'destroy'])->name('subcategories.destroy');

Route::get('/brands-list', [BrandController::class, 'index'])->name('brands.index');
Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
Route::put('/brands/{id}', [BrandController::class, 'update'])->name('brands.update');
Route::delete('/brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{id}',[SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

});

require __DIR__.'/auth.php';
