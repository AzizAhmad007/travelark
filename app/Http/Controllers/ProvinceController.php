<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function getProvince()
    {
        $data = Province::all();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
