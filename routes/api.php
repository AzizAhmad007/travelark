<?php


use App\Http\Controllers\DestinationController;
use App\Http\Controllers\Destination_detailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\CitiController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\Instant_travelerController;
use App\Http\Controllers\PalaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvinceController as ControllersProvinceController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TripPackageController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Trip_AcomodationController;

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


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group([

    'prefix' => 'guide'

], function ($router) {

    Route::get('guide', [GuideController::class, 'index']);
    Route::put('guide/{id}', [GuideController::class, 'update']);
    Route::delete('guide/{id}', [GuideController::class, 'destroy']);
    Route::post('guide', [GuideController::class, 'store']);
});
Route::group([

    'prefix' => 'palace'

], function ($router) {

    Route::post('palace', [PalaceController::class, 'store']);
    Route::get('palace', [PalaceController::class, 'index']);
    Route::get('palace/{id}', [PalaceController::class, 'show']);
    Route::post('palace/{id}', [PalaceController::class, 'update']);
    Route::delete('palace/{id}', [PalaceController::class, 'delete']);
});
Route::group([

    'prefix' => 'ticket'

], function ($router) {


    Route::get('/ticket', [TicketController::class, 'index']);
    Route::post('/ticket', [TicketController::class, 'store']);
    Route::get('ticket/{id}', [TicketController::class, 'show']);
    Route::delete('ticket/{id}', [TicketController::class, 'delete']);
});
Route::group([

    'prefix' => 'instant-travel'

], function ($router) {


    Route::get('/instant-travel',  [Instant_travelerController::class, 'index']);
    Route::get('/instant-travel/{id}',  [Instant_travelerController::class, 'show']);
    Route::post('/instant-travel',  [Instant_travelerController::class, 'store']);
    Route::put('/instant-travel/{id}',  [Instant_travelerController::class, 'update']);
    Route::delete('/instant-travel/{id}',  [Instant_travelerController::class, 'delete']);
});
Route::group([

    'prefix' => 'instant-travel'

], function ($router) {


    Route::get('/trip-package',  [TripPackageController::class, 'index']);
    Route::get('/trip-package/{id}',  [TripPackageController::class, 'show']);
    Route::post('/trip-package',  [TripPackageController::class, 'store']);
    Route::put('/trip-package/{id}',  [TripPackageController::class, 'update']);
    Route::delete('/trip-package/{id}',  [TripPackageController::class, 'delete']);
});
Route::group([

    'prefix' => 'destination'

], function ($router) {


    Route::post('/insert-destination', [DestinationController::class, 'store']);
    Route::put('/update-destination/{id}', [DestinationController::class, 'update']);
    Route::get('/destination/{id}', [DestinationController::class, 'show']);
    Route::get('/destination', [DestinationController::class, 'index']);
    Route::delete('/delete-destination/{id}', [DestinationController::class, 'destroy']);
});
Route::group([

    'prefix' => 'destination-detail'

], function ($router) {


    Route::get('/destination-detail', [Destination_detailController::class, 'index']);
    Route::get('/destination-detail/{id}', [Destination_detailController::class, 'show']);
    Route::post('/destination-detail', [Destination_detailController::class, 'store']);
    Route::put('/destination-detail/{id}', [Destination_detailController::class, 'update']);
    Route::delete('/destination-detail/{id}', [Destination_detailController::class, 'destroy']);
});
Route::group([

    'prefix' => 'trip-acomodation'

], function ($router) {

    Route::get('trip-acomodation', [Trip_AcomodationController::class, 'index']);
    Route::get('trip-acomodation/{id}', [Trip_AcomodationController::class, 'show']);
    Route::put('trip-acomodation/{id}', [Trip_AcomodationController::class, 'update']);
    Route::delete('trip-acomodation/{id}', [Trip_AcomodationController::class, 'destroy']);
    Route::post('trip-acomodation', [Trip_AcomodationController::class, 'store']);
});



Route::get('/province', [ControllersProvinceController::class, 'getProvince']);
Route::get('/city',  [CitiController::class, 'index']);
Route::get('/country',  [CountryController::class, 'index']);
Route::get('/tags',  [TagController::class, 'index']);
