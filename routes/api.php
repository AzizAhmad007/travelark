<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\CitiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvinceController as ControllersProvinceController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);

});

Route::post('guide', [GuideController::class, 'store']);
Route::get('guide', [GuideController::class, 'index']);
Route::put('guide/{id}', [GuideController::class, 'update']);
Route::delete('guide/{id}', [GuideController::class, 'destroy']);
Route::get('/province', [ControllersProvinceController::class, 'getProvince']);
Route::get('/city',  [CitiController::class, 'index']);
