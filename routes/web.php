<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [MainController::class, 'home'])->name('home');

// Route::get('/', [MainController::class, 'home'])->name('home');

Route::resource('/categories', CategoryController::class);
Route::resource('/products', ProductController::class);
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');

Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
Route::post('/sales/create/processing', [SaleController::class, 'store'])->name('sales.store');
Route::delete('/sales/delete/{id}', [SaleController::class, 'destroy'])->name('sales.destroy');
Route::get('/sales/print/{id}', [SaleController::class, 'show'])->name('sales.print');
// Route::get('/print/{sale_id}/receipts', [SaleController::class, 'print'])->name('print.receipts');


Route::get('/', [ClientController::class, 'store'])->name('login');
Route::post('/login/processing', [ClientController::class, 'show'])->name('login.processing');
// Route::post('/login/traitement', [ClientController::class, ' traitementLogin']);
Route::get('/register', [ClientController::class, 'index'])->name('user.register');
Route::post('/register/processing', [ClientController::class, 'create'])->name('register.processing');
Route::get('/logout', [ClientController::class, 'destroy'])->name('logout');
Route::get('/profile/{id}/edit', [ClientController::class, 'edit'])->name('profile.edit');
Route::patch('/profiles/update/{id}', [ClientController::class, 'update'])->name('profiles.update');



Route::get('/monthly-sales', [SaleController::class, 'getMonthlySales']);
Route::get('/bilan/bilan', [SaleController::class, 'report'])->name('sales.show.report');