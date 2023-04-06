<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function index()
    {
        $response = new Responses;
        try {
            $data = Tag::all();
            return $response->Response("success", $data, 200);
        } catch (\Throwable $th) {
             return $response->Response($th->getMessage(), null, 500);
        }
    }
}
