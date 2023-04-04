<?php

namespace App\Http\Controllers;

use App\Models\Palace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PalaceController extends Controller
{
    public function index()
    {
        try {
            $data = Palace::with('user', 'tag', 'country', 'city', 'province')->get();
            foreach ($data as $key => $value) {

                $dataTransform[] = [
                    "id" => $value->id,
                    "user_id" => $value->user->fullname,
                    "tag_id" => $value->tag->name,
                    "country_id" => $value->country->name,
                    "city_id" => $value->city->name,
                    "province_id" => $value->province->name,
                    "palace_name" => $value->palace_name,
                    "image" => Storage::url('public/images/' . $value->image),
                    "price" => $value->price,
                    "description" => $value->description,
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
            $imageName = Str::random(40) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $isValidateData['image'] = $imageName;
            Palace::create($isValidateData);
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

    public function update(Request $request, Palace $palace)
    {
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
            $imageName = Str::random(40) . '.' . $image->getClientOriginalExtension();
            $path = 'public/images/' . $isValidateData['image'];
            Storage::delete($path);
            $image->storeAs('public/images', $imageName);
            $isValidateData['image'] = $imageName;
            $palace->update($isValidateData);
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
            $getData = Palace::find($id);
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
                "tag_id" => $checkData->tag->name,
                "country_id" => $checkData->country->name,
                "city_id" => $checkData->city->name,
                "province_id" => $checkData->province->name,
                "palace_name" => $checkData->palace_name,
                "image" => Storage::url('public/images/' . $checkData->image),
                "price" => $checkData->price,
                "description" => $checkData->description,
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
