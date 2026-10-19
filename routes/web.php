<?php

use Illuminate\Support\Facades\Route;
use App\Models\{Category, Customer, Order, OrderItem, Product};
use App\Http\Controllers\{CategoryController, ProductController, CustomerController, OrderController, OrderItemController};

Route::get('/', function () {
    return view('dashboard', [
        'stats' => [
            'categories' => Category::count(),
            'products' => Product::count(),
            'customers' => Customer::count(),
            'orders' => Order::count(),
            'order_items' => OrderItem::count(),
            'sales' => Order::where('status', 'completed')->sum('total_amount'),
        ],
        'recentOrders' => Order::with('customer')->latest()->take(5)->get(),
        'lowStockProducts' => Product::with('category')->where('stock', '<=', 5)->orderBy('stock')->take(5)->get(),
    ]);
})->name('dashboard');
Route::resource('categories', CategoryController::class)->parameters(['categories' => 'record']);
Route::resource('products', ProductController::class)->parameters(['products' => 'record']);
Route::resource('customers', CustomerController::class)->parameters(['customers' => 'record']);
Route::resource('orders', OrderController::class)->parameters(['orders' => 'record']);
Route::resource('order-items', OrderItemController::class)->parameters(['order-items' => 'record']);
