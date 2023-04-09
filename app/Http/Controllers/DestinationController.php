<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Responses\Responses;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DestinationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function index()
    {
        $response = new Responses;
        try {
            $data = Destination::with('user', 'tag', 'country', 'city', 'province')->get();
            foreach ($data as $key => $value) {
            $imageContent = Storage::get($value->image);
               $dataTransform[] = [
                    "id" => $value->id,
                    "user_id" => $value->user->fullname,
                    "tag_id" => $value->tag->name,
                    "country_id" => $value->country->name,
                    "city_id" => $value->city->name,
                    "province_id" => $value->province->name,
                    "destination_name" => $value->destination_name,
                    "image" => base64_encode($imageContent),
                    "price" => $value->price,
                    "private_price" => $value->private_price,
                    "description" => $value->description,
                ];
            }
             return $response->Response("Success", $dataTransform, 200);
        } catch (\Throwable $th) {
             return $response->Response($th->getMessage(), null, 500);
        }
    }

    public function store(Request $request)
    {
        $response = new Responses;
        try {
            $destination = $request->validate([
                'user_id' => 'required|numeric',
                'tag_id' => 'required|numeric',
                'country_id' => 'required|numeric',
                'city_id' => 'required|numeric',
                'province_id' => 'required|numeric',
                'destination_name' => 'required|min:3|max:100',
                'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
                'price' => 'required|numeric|max:7',
                'description' => 'required',
                'private_price' => 'required|numeric|max:7'
            ]);

            $image = $request->file('image');
            $path = $image->store('public/destinations');
            $destination['image'] = $path;

            Destination::create($destination);

            return $response->Response("success", $destination, 200);
        } catch (Exception $e) {
             return $response->Response($e->getMessage(), null, 400);
        }
    }

    public function show($id)
    {
            $response = new Responses;
            $checkData = Destination::find($id);
            if ($checkData === []) {
                 return $response->Response("Data Not Found", null, 400);
            } else {
                $imageContent = Storage::get($checkData->image);
                $destination = [
                'user_id' => $checkData->user_id,
                'tag_id' => $checkData->tag_id,
                'country_id' => $checkData->country_id,
                'city_id' => $checkData->city_id,
                'province_id' => $checkData->province_id,
                'destination_name' => $checkData->destination_name,
                'image' => base64_encode($imageContent),
                'price' => $checkData->price,
                'description' => $checkData->description,
                'private_price' => $checkData->private_price
                ];
                 return $response->Response("success", $destination, 200);
            }

          
       
    }

    public function update(Request $request, $id)
    {
        $response = new Responses;
        try {
            $request->validate([
                'user_id' => 'required|numeric',
                'tag_id' => 'required|numeric',
                'country_id' => 'required|numeric',
                'city_id' => 'required|numeric',
                'province_id' => 'required|numeric',
                'destination_name' => 'required|min:3|max:100',
                'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
                'price' => 'required|numeric|max:7',
                'description' => 'required',
                'private_price' => 'required|numeric|max:7'
            ]);

            $destination = Destination::find($id);
            $setImage = $request->file('image');
            $pathUpdate = $setImage->store('public/destinations');
            $path = $destination->image;
            Storage::delete($path);
            $data = $request->all();

            $destination->update([
                'user_id' => $request->user_id,
                'tag_id' => $request->tag_id,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'province_id' => $request->province_id,
                'destination_name' => $request->destination_name,
                'image' => $pathUpdate,
                'price' => $request->price,
                'description' => $request->description,
                'private_price' => $request->private_price
            ]);

           return $response->Response("success", $data, 200);
        } catch(Exception $e) {
           return $response->Response($e->getMessage(), null, 400);
        }
    }

    public function destroy($id)
    {
         $response = new Responses;
        try {
            $destination = Destination::find($id);
            if ($destination == null || $destination === []) {
                return $response->Response("Data Not Found", null, 404);
            }

            $path = $destination->image;
            Storage::delete($path);
            $destination->delete();

            return $response->Response("success", $destination, 200);
        } catch (Exception $e) {
            return $response->Response($e->getMessage(), null, 400);
        }
    }
}
