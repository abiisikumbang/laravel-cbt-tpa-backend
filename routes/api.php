<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WasteController;
use App\Http\Controllers\RewardRedeemController;
use App\Http\Controllers\RewardItemController;

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

// Public Routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/user/points', [UserController::class, 'getPoints']);

    //Sell Routes
    Route::post('/sell', [SellController::class, 'store']);
    Route::get('/sell/history', [SellController::class, 'history']);
    Route::get('/sell/history/{id}', [SellController::class, 'show']);

    Route::get('/wastes', [WasteController::class, 'index']);
    // Redeem Routes

    //route untuk menyimpan/membuat transaksi redeem
    Route::post('/rewards/redeem', [RewardRedeemController::class, 'store']);
    //route untuk menampilkan history redeem
    Route::get('/rewards/history', [RewardRedeemController::class, 'history']);
    //route untuk menampilkan data reward
    Route::get('/rewards', [RewardItemController::class, 'index']);

    Route::post('logout', [AuthController::class, 'logout']);
});




