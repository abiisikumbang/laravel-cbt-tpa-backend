<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware(['auth']) ->group(function () {
    Route::get('home', function () {
        return view ('pages.dashboard');
    })->name('home');

    Route::resource('users', UserController::class);
});

Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
// Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');

// Route::put('user/{user}', [UserController::class, 'update'])->name('users.update');



//  Route::get('/login', function () {
//      return view('pages.auth.login');
//  })->name('login');

//  Route::get('/register', function () {
//      return view('pages.auth.register');
//  })->name('register');

//  Route::get(uri: '/users', action:function():View {
//      return view(view: 'pages.users.index');
//  });
