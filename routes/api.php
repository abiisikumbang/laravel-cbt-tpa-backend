<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WasteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// fungsi untuk register
Route::post('register', [AuthController::class, 'register']);

// fungsi untuk login
Route::post('login', [AuthController::class, 'login']);

// fungsi untuk mengambil data user yang login
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// fungsi untuk mengambil data semua waste
Route::get('/wastes', [WasteController::class, 'index']);

// fungsi untuk membuat transaksi penjualan
Route::middleware('auth:sanctum')->post('/sell', [SellController::class, 'store']);

// fungsi untuk mengambil data transaksi penjualan berdasarkan user yang login
Route::middleware('auth:sanctum')->get('/sell/history', [SellController::class, 'history']);

// fungsi untuk mengambil data poin user yang login
Route::middleware('auth:sanctum')->get('/user/points', [UserController::class, 'getPoints']);

// // fungsi untuk mengupdate status penjualan menjadi pickup
// Route::middleware('auth:sanctum')->post('/sell/{id}/pickup', [SellController::class, 'pickup']);

// // fungsi untuk mengupdate status penjualan menjadi mark processed
// Route::middleware('auth:sanctum')->post('/sell/{id}/mark-processed', [SellController::class, 'markProcessed']);

// // fungsi untuk mengupdate status penjualan menjadi complete
// Route::middleware('auth:sanctum')->post('/sell/{id}/complete', [SellController::class, 'completeTransaction']);




// grup route untuk fungsi logout
Route::middleware('auth:sanctum')->group(function(){
    // fungsi untuk logout
    Route::post('logout', [AuthController::class, 'logout']);
});


