<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\InstantTravelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Instant_travelerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function index()
    {
        try {
            $data = InstantTravelModel::with('user', 'palace')->get();
            foreach ($data as $key => $value) {

                $dataTransform[] = [
                    "id" => $value->id,
                    "user_id" => $value->user->fullname,
                    "palace_id" => $value->palace->palace_name,
                    "quota" => $value->quota,
                ];
            }
            return response()->json([
                "message" => "success",
                'statusCode' => 200,
                "data" => $dataTransform,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                'statusCode' => 400,
                "data" => null
            ]);
        }
    }
    public function store(Request $request)
    {
        $response = new Responses;
        try {
            $isValidateData = $request->validate([
                "user_id" => 'required|numeric',
                "palace_id" => 'required|numeric',
                "quota" => 'required|numeric',
            ]);
            InstantTravelModel::create($isValidateData);
             return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

    public function update(Request $request, $id)
    {
        $response = new Responses;
        try {
            $isValidateData = $request->validate([
                "user_id" => 'required|numeric',
                "palace_id" => 'required|numeric',
                "quota" => 'required|numeric',
            ]);
            $getData = InstantTravelModel::find($id);
            $getData->user_id = $isValidateData["user_id"];
            $getData->palace_id = $isValidateData["palace_id"];
            $getData->quota = $isValidateData["quota"];
            $getData->save();
            return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
           return $response->Response($th->getMessage(), null, 400);
        }
    }

    public function delete($id)
    {
        $response = new Responses;
        try {
            $getData = InstantTravelModel::find($id);
            InstantTravelModel::where('id', $id)->delete();
            return $response->Response("success", $getData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

    public function show($id)
    {
        $response = new Responses;
        $checkData  = InstantTravelModel::find($id);
        if (!$checkData == []) {
            $setData = [
                "id" => $checkData->id,
                "user_id" => $checkData->user->fullname,
                "palace_id" => $checkData->palace->palace_name,
                "quota" => $checkData->quota,
            ];
            return $response->Response("success", $setData, 200);
        } else {
           return $response->Response("Data Not Found", null, 404);
        }
    }
}
