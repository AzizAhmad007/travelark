<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\CitiController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PalaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvinceController as ControllersProvinceController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TripPackageController;

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
Route::post('palace', [PalaceController::class, 'store']);
Route::get('palace', [PalaceController::class, 'index']);
Route::get('palace/{id}', [PalaceController::class, 'show']);
Route::put('palace/{id}', [PalaceController::class, 'update']);
Route::delete('palace/{id}', [PalaceController::class, 'delete']);
Route::get('guide', [GuideController::class, 'index']);
Route::put('guide/{id}', [GuideController::class, 'update']);
Route::delete('guide/{id}', [GuideController::class, 'destroy']);
Route::get('/province', [ControllersProvinceController::class, 'getProvince']);
Route::get('/city',  [CitiController::class, 'index']);
Route::get('/country',  [CountryController::class, 'index']);
Route::get('/tags',  [TagController::class, 'index']);

Route::get('/trip-package',  [TripPackageController::class, 'index']);
Route::get('/trip-package/{id}',  [TripPackageController::class, 'show']);
Route::post('/trip-package',  [TripPackageController::class, 'store']);
Route::put('/trip-package/{id}',  [TripPackageController::class, 'update']);
Route::delete('/trip-package/{id}',  [TripPackageController::class, 'delete']);