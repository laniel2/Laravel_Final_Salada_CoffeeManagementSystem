<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CategoryController, ProductController, CustomerController, OrderController, OrderItemController};

Route::get('/', function () { return view('dashboard'); })->name('dashboard');
Route::resource('categories', CategoryController::class)->parameters(['categories' => 'record']);
Route::resource('products', ProductController::class)->parameters(['products' => 'record']);
Route::resource('customers', CustomerController::class)->parameters(['customers' => 'record']);
Route::resource('orders', OrderController::class)->parameters(['orders' => 'record']);
Route::resource('order-items', OrderItemController::class)->parameters(['order-items' => 'record']);
