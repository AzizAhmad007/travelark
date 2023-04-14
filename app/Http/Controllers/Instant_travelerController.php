<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\InstantTravelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Module\imageCompress\ImageCompress;

class Instant_travelerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function index()
    {
        $response = new Responses();
        try {
            $data = InstantTravelModel::with('user', 'palace')->get();
            foreach ($data as $key => $value) {
                $compress = new ImageCompress();
                $image = $compress->getImage($value->image);
                $dataTransform[] = [
                    "id" => $value->id,
                    "user" => $value->user->username,
                    "palace" => $value->palace->palace_name,
                    "image" => $image,
                ];
            }
            return $response->Response("success", $dataTransform, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }
    public function store(Request $request)
    {
        $response = new Responses();
        try {
            $isValidateData = $request->validate([
                "user_id" => 'required|numeric',
                "palace_id" => 'required|numeric',
                "image" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $image = $request->file('image');
             $compress = new ImageCompress();
            $imageAfterCompress = $compress->compress($image);
            $imeg = $compress->store("storage/palaces/",$imageAfterCompress);
            $isValidateData['image'] = $imeg;
            InstantTravelModel::create($isValidateData);
             return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

    public function update(Request $request, $id)
    {
        $response = new Responses();
        try {
            $isValidateData = $request->validate([
                "user_id" => 'required|numeric',
                "palace_id" => 'required|numeric',
                "image" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $getData = InstantTravelModel::find($id);
             $setImage = $request->file('image');
           $compress = new ImageCompress();
            $imageAfterCompress = $compress->compress($setImage);
            $imeg = $compress->store("storage/palaces/",$imageAfterCompress);
            $path = $getData->image;
            unlink($path);
            $getData->user_id = $isValidateData["user_id"];
            $getData->palace_id = $isValidateData["palace_id"];
            $getData->image = $imeg;
            $getData->save();
            return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
           return $response->Response($th->getMessage(), null, 400);
        }
    }

    public function delete($id)
    {
        $response = new Responses();
        try {
            $getData = InstantTravelModel::find($id);
            InstantTravelModel::where('id', $id)->delete();
            $path = $getData->image;
            unlink($path);
            return $response->Response("success", $getData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

    public function show($id)
    {
        $response = new Responses();
        $checkData  = InstantTravelModel::find($id);
        if (!$checkData == []) {
            $compress = new ImageCompress();
            $image = $compress->getImage($checkData->image);
            $setData = [
                "id" => $checkData->id,
                "user" => $checkData->user->username,
                "palace" => $checkData->palace->palace_name,
                "image" => $image,
            ];
            return $response->Response("success", $setData, 200);
        } else {
           return $response->Response("Data Not Found", null, 404);
        }
    }
}
