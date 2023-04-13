<?php

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

Route::get('/', function () {
    $exists = public_path('/storage/palaces');
    if(file_exists($exists)){
        return "YEAY ITS WORK";
    }else{
        return "NO WORK";
    }
});
