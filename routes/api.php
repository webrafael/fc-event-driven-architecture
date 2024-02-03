<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::resource('/clients', ClientController::class)->only(['index', 'store']);
Route::resource('/accounts', AccountController::class)->only(['index', 'store']);
Route::resource('/transactions', TransactionController::class)->only(['index', 'store']);
Route::get('balances/{account_id?}', [BalanceController::class, 'get'])->name('balances.account');
