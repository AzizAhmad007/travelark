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
        $destination = Destination::all();
        return $destination;
    }

    public function store(Request $request)
    {
        $response = new Responses;
        try {
            $destination = $request->validate([
                'user_id' => 'required',
                'tag_id' => 'required',
                'country_id' => 'required',
                'city_id' => 'required',
                'province_id' => 'required',
                'destination_name' => 'required',
                'image' => 'required|image|mimes:jpeg,jpg,png|max:2000',
                'price' => 'required',
                'description' => 'required',
                'private_price' => 'required'
            ]);

            $image = $request->file('image');
            $imageName = Str::random(40) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/destinations', $imageName);
            $destination['image'] = $imageName;

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
                $destination = [
                'user_id' => $checkData->user_id,
                'tag_id' => $checkData->tag_id,
                'country_id' => $checkData->country_id,
                'city_id' => $checkData->city_id,
                'province_id' => $checkData->province_id,
                'destination_name' => $checkData->destination_name,
                'image' => Storage::url('public/destinations/' . $checkData->image),
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
            $destination = $request->validate([
                'user_id' => 'required',
                'tag_id' => 'required',
                'country_id' => 'required',
                'city_id' => 'required',
                'province_id' => 'required',
                'destination_name' => 'required',
                'image' => 'required',
                'price' => 'required',
                'description' => 'required',
                'private_price' => 'required'
            ]);

            $destination = Destination::find($id);
            $image = $request->file('image');
            $imageName = Str::random(40) . '.' . $image->getClientOriginalExtension();
            $path = 'public/destinations/' . $destination->image;
            Storage::delete($path);
            $image->storeAs('public/destinations', $imageName);
            $destination['image'] = $imageName;
            $data = $request->all();

            $destination->update([
                'user_id' => $request->user_id,
                'tag_id' => $request->tag_id,
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'province_id' => $request->province_id,
                'destination_name' => $request->destination_name,
                'image' => $imageName,
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

            $path = 'public/destinations/' . $destination->image;
            Storage::delete($path);
            $destination->delete();

            return $response->Response("success", $destination, 200);
        } catch (Exception $e) {
            return $response->Response($e->getMessage(), null, 400);
        }
    }
}
