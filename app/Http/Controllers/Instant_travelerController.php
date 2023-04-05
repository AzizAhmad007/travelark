<?php

namespace App\Http\Controllers;

use App\Models\InstantTravelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Instant_travelerController extends Controller
{
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
        try {
            $isValidateData = $request->validate([
                "user_id" => 'required|numeric',
                "palace_id" => 'required|numeric',
                "quota" => 'required|numeric',
            ]);
            InstantTravelModel::create($isValidateData);
            return response()->json([
                "message" => "success",
                'statusCode' => 200,
                "data" => $isValidateData,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                'statusCode' => 400,
                "data" => null
            ]);
        }
    }

    public function update(Request $request, $id)
    {
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
            return response()->json([
                "message" => "success",
                'statusCode' => 200,
                "data" => $isValidateData,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                'statusCode' => 400,
                "data" => null
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $getData = InstantTravelModel::find($id);
            InstantTravelModel::where('id', $id)->delete();
            return response()->json([
                "message" => "success",
                'statusCode' => 200,
                'data' => $getData
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                'statusCode' => 400,
                'data' => null
            ]);
        }
    }

    public function show($id)
    {
        $checkData  = InstantTravelModel::find($id);
        if (!$checkData == []) {
            $setData = [
                "id" => $checkData->id,
                "user_id" => $checkData->user->fullname,
                "palace_id" => $checkData->palace->palace_name,
                "quota" => $checkData->quota,
            ];
            return response()->json([
                "message" => "success",
                'statusCode' => 200,
                "data" => $setData
            ]);
        } else {
            return response()->json([
                "message" => 'error data tidak di temukan',
                'statusCode' => 404,
                "data" => null
            ]);
        }
    }
}
