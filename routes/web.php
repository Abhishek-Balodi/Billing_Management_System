<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return view('layout-horizontal');
})->name('home');

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
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
