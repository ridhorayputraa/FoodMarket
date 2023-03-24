<?php

use App\Http\Controllers\API\MidtransController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


// Home Page
Route::get('/', function () {
    // arahkan ke yang sudah di bikin dibawah
    return redirect()->route('dashboard');
});

// Dashboard
// Perlu route prefix agar semua route ini depannya ada dashboard nya
Route::prefix('dashboard')
    ->middleware(['auth:sanctum', 'admin'])
    ->group(function() {
        // Routes untuk admin taro disini
        Route::get('/', [DashboardController::class, 'index'])
       ->name('dashboard');
        // Kasih nama routingnya
        Route::resource('users', UserController::class);
        Route::resource('food', FoodController::class);

        Route::resource('transactions', TransactionController::class);
    });
// Midtrans Related
Route::get('midtrans/success', [MidtransController::class, 'success']);
Route::get('midtrans/unfinish', [MidtransController::class, 'unfinish']);
Route::get('midtrans/error', [MidtransController::class, 'error']);
