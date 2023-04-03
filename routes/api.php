<?php

use App\Http\Controllers\GuideController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('guide', [GuideController::class, 'store']);
Route::get('guide', [GuideController::class, 'index']);
Route::put('guide/{id}', [GuideController::class, 'update']);
Route::delete('guide/{id}', [GuideController::class, 'destroy']);
