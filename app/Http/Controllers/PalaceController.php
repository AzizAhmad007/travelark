<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\Palace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Module\imageCompress\ImageCompress;

class PalaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function index()
    {
        $response = new Responses();
        try {
            $data = Palace::with('user', 'tag', 'country', 'city', 'province')->get();
            foreach ($data as $key => $value) {
                $compress = new ImageCompress();
                $image = $compress->getImage($value->image);
                $dataTransform[] = [
                    "id" => $value->id,
                    "user" => $value->user->username,
                    "tag" => $value->tag->name,
                    "country" => $value->country->name,
                    "city" => $value->city->name,
                    "province" => $value->province->name,
                    "palace_name" => $value->palace_name,
                    "image" => $image,
                    "price" => $value->price,
                    "description" => $value->description,
                ];
            }
            return $response->Response("success", $dataTransform, 200);
        } catch (\Throwable $th) {
           return $response->Response($th->getMessage(), null, 500);
        }
    }
    public function store(Request $request)
    {
         $response = new Responses();
        try {
            $isValidateData = $request->validate([
                "user_id" => 'required|numeric',
                "tag_id" => 'required|numeric',
                "country_id" => 'required|numeric',
                "city_id" => 'required|numeric',
                "province_id" => 'required|numeric',
                "palace_name" => 'required|min:3|max:100',
                "image" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                "price" => 'required||numeric',
                "description" => 'required|min:2',
            ]);
            $image = $request->file('image');
            $compress = new ImageCompress();
            $imageAfterCompress = $compress->compress($image);
            $imeg = $compress->store("storage/palaces/",$imageAfterCompress);
            $isValidateData['image'] = $imeg;
            Palace::create($isValidateData);
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
                "tag_id" => 'required|numeric',
                "country_id" => 'required|numeric',
                "city_id" => 'required|numeric',
                "province_id" => 'required|numeric',
                "palace_name" => 'required|min:3|max:100',
                "price" => 'required||numeric',
                "description" => 'required|min:2',
            ]);
             $getData = Palace::find($id);
            $setImage = $request->file('image');
            $compress = new ImageCompress();
            $imageAfterCompress = $compress->compress($setImage);
            $imeg = $compress->store("storage/palaces/",$imageAfterCompress);
            // $pathUpdate = $setImage->store('public/palaces');
            $path = $getData->image;
            unlink($path);

            $getData->user_id = $isValidateData["user_id"];
            $getData->tag_id = $isValidateData["tag_id"];
            $getData->country_id = $isValidateData["country_id"];
            $getData->city_id = $isValidateData["city_id"];
            $getData->province_id = $isValidateData["province_id"];         
            $getData->palace_name = $isValidateData["palace_name"];
            $getData->image =  $imeg;
            $getData->price = $isValidateData["price"];
            $getData->description = $isValidateData["description"];
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
            $getData = Palace::find($id);
            Palace::where('id', $id)->delete();
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
        $checkData  = Palace::find($id);
        if (!$checkData == []) {
            $compress = new ImageCompress();
            $image = $compress->getImage($checkData->image);
            $setData = [
                "id" => $checkData->id,
                "user" => $checkData->user->username,
                "tag" => $checkData->tag->name,
                "country" => $checkData->country->name,
                "city" => $checkData->city->name,
                "province" => $checkData->province->name,
                "palace_name" => $checkData->palace_name,
                "image" => $image,
                "price" => $checkData->price,
                "description" => $checkData->description,
            ];
           return $response->Response("success", $setData, 200);
        } else {
             return $response->Response("Data Not Found", null, 404);
        }
    }
}
