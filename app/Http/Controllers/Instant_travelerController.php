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
                    "palace_id" => $value->palace->name,
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
            Palace::where('id', $id)->delete();
             $path = 'public/images/' . $getData->image;
            Storage::delete($path);
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
        $checkData  = Palace::find($id);
        if (!$checkData == []) {
            $setData = [
                "id" => $checkData->id,
                "user_id" => $checkData->user->fullname,
                "palace_id" => $checkData->palace->name,
                "quota" => $checkData->quota->name,
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
