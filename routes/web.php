<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use App\Http\Controllers\SellController;
use App\Livewire\Admin\TransactionList;
use App\Http\Controllers\TransactionController;

//Menampilkan halaman login jika user belum login
Route::get('/', function () {
    return view('pages.auth.login');
});
Route::resource('home', DashboardController::class)->middleware('auth');

//Menampilkan halaman create user
Route::resource('users', UserController::class)->middleware('auth');

//Membuat route untuk submit create user
Route::post('users', [UserController::class, 'store'])->name('users.store');

//Menampilkan halaman edit user
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

//Membuat route untuk update user
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

// Profil
// menampilkan halaman profil
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::post('/sell/{id}/pickup', [SellController::class, 'pickup']);
    Route::post('/sell/{id}/mark-processed', [SellController::class, 'markProcessed']);
    Route::post('/sell/{id}/complete', [SellController::class, 'completeTransaction']);
});

Route::middleware(['auth', 'admin'])->get('/admin/sell/all', [SellController::class, 'allTransactions']);


//Membuat route untuk update data diri
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

//Membuat route untuk ganti password
Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    //Menampilkan halaman profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    //Membuat route untuk update data diri
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    //Membuat route untuk ganti password
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::patch('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
});

Route::get('/tabel-transaksi', [TransactionController::class, 'index'])->name('transactions.index');


// Route untuk Logout
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout')->middleware('auth');
