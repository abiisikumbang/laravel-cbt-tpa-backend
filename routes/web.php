<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RedeemController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\WasteController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Auth\RegisterController;

// Public Routes
Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomLoginController::class, 'store'])
        ->middleware('throttle:3,1');
    Route::post('/register', [RegisterController::class, 'store'])->name('register');
});

Route::post('/logout', [CustomLoginController::class, 'logout'])->name('logout');

// Admin Protected Routes
Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    
    // Dashboard
    Route::resource('dashboard', DashboardController::class);
    
    // User Management
    Route::resource('users', UserController::class);
    
    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('/update', [ProfileController::class, 'updateProfile'])->name('update');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('changePassword');
    });
    
    // Transaction Management
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [SellController::class, 'index'])->name('index');
        Route::post('/{transaction}/pickup', [SellController::class, 'pickup'])->name('pickup');
        Route::post('/{transaction}/mark-processed', [SellController::class, 'markProcessed'])->name('markProcessed');
        Route::post('/{transaction}/complete', [SellController::class, 'completeTransaction'])->name('complete');
        Route::post('/{transaction}/cancel', [SellController::class, 'cancelTransaction'])->name('cancel');
        Route::delete('/{transaction}', [SellController::class, 'deleteTransaction'])->name('delete');
    });
    
    // Redeem Management
    Route::prefix('redeems')->name('redeems.')->group(function () {
        Route::get('/', [RedeemController::class, 'index'])->name('index');
        Route::get('/{redeem}/detail', [RedeemController::class, 'detail'])->name('detail');
        Route::post('/{redeem}/delivered', [RedeemController::class, 'delivered'])->name('delivered');
        Route::post('/{redeem}/processed', [RedeemController::class, 'Processed'])->name('processed');
        Route::post('/{redeem}/complete', [RedeemController::class, 'completeRedeem'])->name('complete');
        Route::post('/{redeem}/cancel', [RedeemController::class, 'cancelRedeem'])->name('cancel');
        Route::delete('/{redeem}', [RedeemController::class, 'deleteTransaction'])->name('delete');
    });
    
    // Resource Management
    Route::resource('wastes', WasteController::class);
    Route::resource('stocks', StockController::class);
});

