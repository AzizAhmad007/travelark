<?php

namespace App\Http\Controllers;

use App\Models\Countries;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
     public function index()
    {
        try{
            return response()->json([
            "message" => "success",
            "statusCode" => 200,
            "data" => Country::all(),
        ]);
        }catch(\Throwable $th){
             return response()->json([
            "message" => $th->getMessage(),
            "statusCode" => 400,
            "data" => null
            ]);
        }
        
    }
}
