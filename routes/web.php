<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'userIndex'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
        
        // Master Data & Inventory
        Route::resource('/materials', \App\Http\Controllers\Admin\MaterialController::class);
        Route::post('/materials/add-stock', [\App\Http\Controllers\Admin\MaterialController::class, 'addStock'])->name('materials.addStock');
        
        // Order Management
        Route::get('/orders', [\App\Http\Controllers\AdminOrderController::class, 'index'])->name('orders.index');
        Route::post('/orders/{order}/approve', [\App\Http\Controllers\AdminOrderController::class, 'approve'])->name('orders.approve');
        Route::post('/orders/{order}/reject', [\App\Http\Controllers\AdminOrderController::class, 'reject'])->name('orders.reject');
    });

    // User Routes (Non-Admin)
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/catalog', [\App\Http\Controllers\UserProductController::class, 'index'])->name('products.index');
        Route::post('/catalog', [\App\Http\Controllers\UserProductController::class, 'store'])->name('products.store');
        Route::get('/orders', [\App\Http\Controllers\UserOrderController::class, 'index'])->name('orders.index');
    });
});

require __DIR__.'/auth.php';
