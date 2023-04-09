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
        $response = new Responses;
        try {
            $data = InstantTravelModel::with('user', 'palace')->get();
            foreach ($data as $key => $value) {
                $imageContent = Storage::get($value->image);
                $dataTransform[] = [
                    "id" => $value->id,
                    "user_id" => $value->user->fullname,
                    "palace_id" => $value->palace->palace_name,
                    "image" => base64_encode($imageContent),
                ];
            }
            return $response->Response("success", $dataTransform, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }
    public function store(Request $request)
    {
        $response = new Responses;
        try {
            $isValidateData = $request->validate([
                "user_id" => 'required|numeric',
                "palace_id" => 'required|numeric',
                "image" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $image = $request->file('image');
            $path = $image->store('public/palaces');
            $isValidateData['image'] = $path;
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
                "image" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $getData = InstantTravelModel::find($id);
             $setImage = $request->file('image');
            $pathUpdate = $setImage->store('public/palaces');
            $path = $getData->image;
            Storage::delete($path);
            $getData->user_id = $isValidateData["user_id"];
            $getData->palace_id = $isValidateData["palace_id"];
            $getData->image = $pathUpdate;
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
            $path = $getData->image;
            Storage::delete($path);
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
             $imageContent = Storage::get($checkData->image);
            $setData = [
                "id" => $checkData->id,
                "user_id" => $checkData->user->fullname,
                "palace_id" => $checkData->palace->palace_name,
                "image" => base64_encode($imageContent),
            ];
            return $response->Response("success", $setData, 200);
        } else {
           return $response->Response("Data Not Found", null, 404);
        }
    }
}
