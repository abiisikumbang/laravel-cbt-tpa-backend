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

Route::get('/', function () {
    return redirect('/login');
});

Route::post('/register', [RegisterController::class, 'store'])->name('register');

// Halaman login
Route::get('/login', [CustomLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomLoginController::class, 'store'])
    ->middleware('throttle:3,1')
    ->name('login');

// Logout
Route::post('/logout', [CustomLoginController::class, 'logout'])->name('logout');



    Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    // Dashboard Routes
    Route::resource('home', DashboardController::class);

    // User and Profile Routes
    // User Routes
    Route::resource('users', UserController::class);

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');

    // Sell Routes
    Route::post('/sell/{id}/pickup', [SellController::class, 'pickup'])->name('sell.pickup');
    Route::post('/sell/{id}/mark-processed', [SellController::class, 'markProcessed']) ->name('sell.markProcessed');
    Route::post('/sell/{id}/complete', [SellController::class, 'completeTransaction']) ->name('sell.completeTransaction');
    Route::delete('/sell/{id}', [SellController::class, 'deleteTransaction'])->name('sell.delete'); //route untuk menghapus transaksi penjualan
    Route::get('/tabel-transaksi', [SellController::class, 'index'])->name('transactions.index'); //route untuk menampilkan tabel transaksi penjualan

    // Redeem Routes
    Route::post('/redeem/{id}/delivered', [RedeemController::class, 'delivered']) ->name('redeem.delivered');
    Route::post('/redeem/{id}/processed', [RedeemController::class, 'Processed'])   ->name('redeem.processed');
    Route::post('/redeem/{id}/complete', [RedeemController::class, 'completeRedeem']) ->name('redeem.complete');
    //route untuk menampilkan tabel redeem
    Route::get('/tabel-redeem', [RedeemController::class, 'index'])->name('redeem.index');
    //route untuk menampilkan detail redeem
    Route::get('/redeem-detail/{id}', [RedeemController::class, 'detail'])->name('redeem.detail');
    Route::delete('/redeem/{id}', [RedeemController::class, 'deleteTransaction'])->name('redeem.delete');

    // Waste Routes
    Route::get('/tabel-sampah', [WasteController::class, 'AdminIndex'])->name('wastes.index'); //route untuk menampilkan tabel sampah
    Route::get('/tambah-sampah', [WasteController::class, 'create'])->name('wastes.create'); //route untuk menampilkan form tambah sampah
    Route::post('/tambah-sampah', [WasteController::class, 'store'])->name('wastes.store'); //route untuk menyimpan sampah
    Route::get('/edit-sampah/{waste}', [WasteController::class, 'edit'])->name('wastes.edit'); //route untuk menampilkan form edit sampah
    Route::put('/edit-sampah/{waste}', [WasteController::class, 'update'])->name('wastes.update'); //route untuk mengupdate sampah
    Route::delete('/hapus-sampah/{waste}', [WasteController::class, 'destroy'])->name('wastes.destroy'); //route untuk menghapus sampah

    // Stock Routes
    Route::resource('stocks', StockController::class); //route untuk mengelola stok reward
});

