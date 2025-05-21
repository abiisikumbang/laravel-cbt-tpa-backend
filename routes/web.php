<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use iluminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

/**
 * Menampilkan halaman login jika user belum login
 */
Route::get('/', function () {
    return view('pages.auth.login');
});

/**
 * Menampilkan halaman dashboard jika user sudah login
 */
Route::middleware(['auth']) ->group(function () {

    Route::get('home', function () {
        return view ('pages.dashboard');
    })->name('home');

    /**
     * Menampilkan halaman create user
     */
    Route::resource('users', UserController::class);
});

/**
 * Membuat route untuk submit create user
 */
Route::post('users', [UserController::class, 'store'])->name('users.store');

/**
 * Menampilkan halaman edit user
 */
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

/**
 * Membuat route untuk update user
 */
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');




// Profil
/**
 * Menampilkan halaman profil
 */
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');

/**
 * Membuat route untuk update data diri
 */
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

/**
 * Membuat route untuk ganti password
 */
Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    /**
     * Menampilkan halaman profil
     */
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    /**
     * Membuat route untuk update data diri
     */
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    /**
     * Membuat route untuk ganti password
     */
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::patch('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
});

