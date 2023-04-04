<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        try{
            return response()->json([
            "message" => "success",
            "statusCode" => 200,
            "data" => Tag::all(),
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
