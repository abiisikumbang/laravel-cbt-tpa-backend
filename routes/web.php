<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use iluminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('pages.auth.login');
});



Route::middleware(['auth']) ->group(function () {
//     route::get('/home', function () {
//         return view('pages.dashboard');
//     })->name('home');
//     Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
//     Route::post('/users', [UserController::class, 'store'])->name('users.store');
//     Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
// });

    Route::get('home', function () {
        return view ('pages.dashboard');
    })->name('home');

    Route::resource('users', UserController::class);
});

// buat route untuk submit create user
Route::post('users', [UserController::class, 'store'])->name('users.store');

Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
route::put('users/{user}', [UserController::class, 'update'])->name('users.update');



// Profil
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');

// Update data diri
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

// Ganti password
Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::patch('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
});


