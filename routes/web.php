<?php

use App\Http\Controllers\AllProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutFinalController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::resource('/', HomeController::class);
Route::resource('/home', HomeController::class);
Route::resource('/all-product', AllProductController::class);
Route::resource('/keranjang', CartController::class);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Dashboard (akses semua role)
Route::middleware(['auth'])->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Rute khusus admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/admin/category', CategoryController::class);
    Route::resource('/admin/product', ProductController::class);
    Route::resource('/admin/order', OrderController::class);
    Route::resource('/admin/users', UsersController::class);

});

// Rute khusus user
Route::middleware(['auth', 'role:user'])->group(function () {
    // Route khusus history (letakkan di atas resource)
    Route::post('/history/pay/{orderId}', [HistoryController::class, 'payOrder'])->name('history.pay');
    Route::get('/history/payment-success', [HistoryController::class, 'paymentSuccess'])->name('history.payment-success');
    Route::get('/history/payment-failed', [HistoryController::class, 'paymentFailed'])->name('history.payment-failed');
    Route::get('/history/invoice/{id}', [HistoryController::class, 'printInvoice'])->name('history.invoice');

    Route::resource('/history', HistoryController::class);
    Route::resource('/settings', SettingController::class);

    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
    Route::post('/cart/process', [CartController::class, 'process'])->name('cart.process');
    Route::get('/cart/payment/success', [CartController::class, 'paymentSuccess'])->name('cart.payment.success');
    Route::get('/cart/payment/failed', [CartController::class, 'paymentFailed'])->name('cart.payment.failed');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

    Route::post('/settings/profile', [SettingController::class, 'updateProfile'])->name('settings.updateProfile');
    Route::post('/settings/password', [SettingController::class, 'updatePassword'])->name('settings.updatePassword');
});
