<?php

use App\Http\Controllers\API\FoodController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function() {
// Kalo udah login taro di dalem
Route::get('user', [UserController::class, 'fetch']);
Route::post('user', [UserController::class, 'updateProfile']);
Route::post('user/photo', [UserController::class, 'updatePhoto']);
Route::post('logout', [UserController::class, 'logout']);

// Checkout
Route::post('checkout', [TransactionController::class, 'checkout']);

// Transaksi
Route::get('transaction', [TransactionController::class, 'all']);
Route::post('transaction/{id}', [TransactionController::class, 'update']);
});

// Kalo belum login taro di luar
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);


// Food api
Route::get('food', [FoodController::class, 'all']);
