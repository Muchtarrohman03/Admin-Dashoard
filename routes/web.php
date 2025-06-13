<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth & verified wajib untuk semua
Route::middleware(['auth', 'verified'])->group(function () {
    // Admin Users → hanya pimpinan & administrator
    Route::middleware(['role:admin|administrator'])->group(function () {
        //manage carousel image
        Route::delete('/product/carousel/{image}', [ProductImageController::class, 'destroy'])->name('product.carousel.delete');

        //Manage Product
        Route::get('/admin/product', [ProductController::class, 'admin'])->name('admin.product');
        Route::post('/admin/product', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/product/preview/{slug}', [ProductController::class, 'preview'])->name('product.preview');
        Route::put('/admin/product/{product}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/admin/product/{product}', [ProductController::class, 'destroy'])->name('admin.product.destroy');

        //Manage Services
        Route::get('/admin/services', [ServiceController::class, 'admin'])->name('admin.services');
        Route::post('/admin/services', [ServiceController::class, 'store'])->name('admin.services.store');
        Route::put('/admin/services/{service}', [ServiceController::class, 'update'])->name('admin.services.update');
        Route::delete('/admin/services/{service}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');

        //Manage Orders
        Route::get('/admin/orders', [OrderController::class, 'admin'])->name('admin.orders');
        Route::post('/admin/orders', [OrderController::class, 'store'])->name('admin.orders.store');
    });
    Route::middleware(['role:pimpinan|administrator'])->group(function () {
        //
        Route::get('/product', [ProductController::class, 'index'])->name('product.index');
        Route::get('/product/preview/{slug}', [ProductController::class, 'preview'])->name('product.preview');
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/export/excel', [ServiceController::class, 'export'])->name('services.export');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        //manage users
        Route::get('/admin/users', [UserController::class, 'admin'])->name('admin.users');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');

    });
        // Profile Routes
    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
});


require __DIR__.'/auth.php';

