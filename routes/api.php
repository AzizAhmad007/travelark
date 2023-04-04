<?php

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\Destination_detailController;
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

Route::post('login', [loginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::prefix('logged')->middleware('auth')->group(function () {
    Route::prefix('admin')->middleware('admin')->group(function () {});
});

        //---------------------------Destination----------------------------
        Route::post('/insert-destination', [DestinationController::class, 'store']);
        Route::put('/update-destination/{id}', [DestinationController::class, 'update']);
        Route::get('/destination/{id}', [DestinationController::class, 'show']);
        Route::get('/destination', [DestinationController::class, 'index']);
        Route::delete('/delete-destination/{id}', [Destination::class, 'destroy']);

        //---------------------------Destination_detail----------------------
        Route::get('/destination-detail', [Destination_detailController::class, 'index']);
        Route::get('/destination-detail/{id}', [Destination_detailController::class, 'show']);
