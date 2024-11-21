<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NasabahController;
use App\Http\Controllers\API\rekeningController;
use App\Http\Controllers\API\TransaksiController;
use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Http\Request;
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


Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('nasabah', [NasabahController::class, 'showAll']);
    Route::get('nasabah/{id}', [NasabahController::class, 'show']);
    Route::get('rekening', [rekeningController::class, 'showAll']);
    Route::put('nasabah/update/{id}', [NasabahController::class, 'update']);
    Route::post('nasabah/create', [NasabahController::class, 'create']);
    Route::delete('nasabah/delete/{id}', [NasabahController::class, 'destroy']);
});

Route::middleware(ApiKeyMiddleware::class)->group(function () {
    Route::get('rekening/{no_rekening}', [rekeningController::class, 'show']);
    Route::post('transaksi', [TransaksiController::class, 'addBuyTransaction']);
});
