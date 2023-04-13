<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\Countries;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function index()
    {
        $response = new Responses();
        try {
            $data = Country::all();
            return $response->Response("success", $data, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 500);
        }
    }
}
