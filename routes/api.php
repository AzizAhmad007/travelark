<?php

use App\Http\Controllers\DestinationController;
use App\Http\Controllers\Destination_detailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Checkout_instant_travel_sumaryController;
use App\Http\Controllers\Checkout_package_travel_sumaryController;
use App\Http\Controllers\DetailPackageController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\CitiController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GuestController;
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
    'middleware' => 'IsAdmin',
    'prefix' => 'guide'

], function ($router) {

    Route::get('guide', [GuideController::class, 'index']);
    Route::put('update-guide/{id}', [GuideController::class, 'update']);
    Route::delete('delete-guide/{id}', [GuideController::class, 'destroy']);
    Route::post('insert-guide', [GuideController::class, 'store']);
});
Route::group([

    'prefix' => 'palace'

], function ($router) {

    Route::post('insert-palace', [PalaceController::class, 'store'])->middleware('IsAdmin');
    Route::get('palace', [PalaceController::class, 'index']);
    Route::get('detail-palace/{id}', [PalaceController::class, 'show'])->middleware('IsAdmin');
    Route::post('update-palace/{id}', [PalaceController::class, 'update'])->middleware('IsAdmin');
    Route::delete('palace/{id}', [PalaceController::class, 'delete'])->middleware('IsAdmin');
});
Route::group([

    'prefix' => 'ticket'

], function ($router) {


    Route::get('ticket', [TicketController::class, 'index'])->middleware('IsAdmin');
    Route::post('insert-ticket', [TicketController::class, 'store'])->middleware('IsTraveler');
    Route::get('detail-ticket/{id}', [TicketController::class, 'show'])->middleware('IsAdmin');
    Route::delete('delete-ticket/{id}', [TicketController::class, 'delete'])->middleware('IsAdmin');
});
Route::group([

    'prefix' => 'instant-travel'

], function ($router) {

    Route::get('instant-travel',  [Instant_travelerController::class, 'index']);
    Route::get('detail-instant-travel/{id}',  [Instant_travelerController::class, 'show'])->middleware('IsAdmin');
    Route::post('insert-instant-travel',  [Instant_travelerController::class, 'store'])->middleware('IsAdmin');
    Route::put('update-instant-travel/{id}',  [Instant_travelerController::class, 'update'])->middleware('IsAdmin');
    Route::delete('delete-instant-travel/{id}',  [Instant_travelerController::class, 'delete'])->middleware('IsAdmin');
});
Route::group([

    'prefix' => 'trip-package'

], function ($router) {


    Route::get('trip-package',  [TripPackageController::class, 'index']);
    Route::get('detail-trip-package/{id}',  [TripPackageController::class, 'show'])->middleware('IsAdmin');
    Route::post('insert-trip-package',  [TripPackageController::class, 'store']);
    Route::put('update-trip-package/{id}',  [TripPackageController::class, 'update'])->middleware('IsAdmin');
    Route::delete('delete-trip-package/{id}',  [TripPackageController::class, 'delete'])->middleware('IsAdmin');
});
Route::group([

    'prefix' => 'destination'

], function ($router) {


    Route::post('insert-destination', [DestinationController::class, 'store'])->middleware('IsAdmin');
    Route::post('update-destination/{id}', [DestinationController::class, 'update'])->middleware('IsAdmin');
    Route::get('detail-destination/{id}', [DestinationController::class, 'show'])->middleware('IsAdmin');
    Route::get('destination', [DestinationController::class, 'index']);
    Route::delete('delete-destination/{id}', [DestinationController::class, 'destroy'])->middleware('IsAdmin');
});
Route::group([

    'prefix' => 'destination-detail'

], function ($router) {


    Route::get('destination-detail', [Destination_detailController::class, 'index'])->middleware('IsAdmin');
    Route::get('detail-destination-detail/{id}', [Destination_detailController::class, 'show']);
    Route::post('insert-destination-detail', [Destination_detailController::class, 'store'])->middleware('IsAdmin');
    Route::put('update-destination-detail/{id}', [Destination_detailController::class, 'update'])->middleware('IsAdmin');
    Route::delete('delete-destination-detail/{id}', [Destination_detailController::class, 'destroy'])->middleware('IsAdmin');
});


Route::group([
    'prefix' => 'detail-package'
], function ($router) {
    Route::get('detail-package', [DetailPackageController::class, 'index']);
    Route::get('detail-detail-package/{id}', [DetailPackageController::class, 'show']);
    Route::post('insert-detail-package', [DetailPackageController::class, 'store']);
    Route::put('update-detail-package/{id}', [DetailPackageController::class, 'update']);
    Route::delete('delete-detail-package/{id}', [DetailPackageController::class, 'delete']);
});


Route::group([
    'prefix' => 'trip-acomodation'

], function ($router) {

    Route::get('trip-acomodation', [Trip_AcomodationController::class, 'index']);
    Route::get('detail-trip-acomodation/{id}', [Trip_AcomodationController::class, 'show']);
    Route::put('update-trip-acomodation/{id}', [Trip_AcomodationController::class, 'update']);
    Route::delete('delete-trip-acomodation/{id}', [Trip_AcomodationController::class, 'destroy']);
    Route::post('insert-trip-acomodation', [Trip_AcomodationController::class, 'store']);
});
Route::group([
    'prefix' => 'guest'

], function ($router) {

    Route::get('destination', [GuestController::class, 'getAllInstantTravel']);
    Route::get('destination-detail/{id}', [GuestController::class, 'instatTravelDetail']);
    Route::get('package-destination', [GuestController::class, 'package']);
    Route::get('package-destination-detail/{id}', [GuestController::class, 'packageDestinationDetail']);
    
   
});
Route::group([
    'prefix' => 'checkout'

], function ($router) {

   Route::post('checkout-destination', [Checkout_instant_travel_sumaryController::class, 'store']);
   Route::post('checkout-package', [Checkout_package_travel_sumaryController::class, 'store']);
   
});


Route::get('/province', [ControllersProvinceController::class, 'getProvince']);
Route::get('/city', [CitiController::class, 'index']);
Route::get('/country', [CountryController::class, 'index']);
Route::get('/tags', [TagController::class, 'index']);
