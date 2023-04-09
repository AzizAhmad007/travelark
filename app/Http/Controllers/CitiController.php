<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\CitiModel;
use Illuminate\Http\Request;

class CitiController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = new Responses;
        try {
            $data = CitiModel::all();
            return $response->Response("success", $data, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 500);
        }
        
    }
}

