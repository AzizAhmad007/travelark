<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

            return response()->json([
                'message' => 'success',
                'statusCOde' => 200,
                "data" => $destination
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e,
                //'error' => $e->getMessage(),
                'error' => 'Terjadi kesalahan',
                'statusCode' => 400,
                'data' => null
            ]);
        }
    }

    public function show($id)
    {
        try {
            $checkData = Destination::find($id);
            if ($checkData == null) {
                throw new Exception('Data tidak ditemukan');
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
            }

            return response()->json([
                'message' => 'Data ditemukan',
                'statusCode' => 200,
                'data' => $destination
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e,
                'error' => 'Data tidak ditemukan',
                'statusCode' => 400,
                'data' => null
            ]);
        }
    }

    public function update(Request $request, $id)
    {
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
                'image' => $request->image,
                'price' => $request->price,
                'description' => $request->description,
                'private_price' => $request->private_price
            ]);

            return response()->json([
                'message' => 'update success',
                'statusCode' => 200,
                'data' => $data
            ]);
        } catch(Exception $e) {
            return response()->json([
                'message' => $e,
                //'error' => $e->getMessage(),
                'error' => 'Terjadi kesalahan',
                'statusCode' => 400,
                'data' => null
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $destination = Destination::find($id);
            if ($destination == null) {
                throw new Exception('Data tidak ditemukan');
            }

            $path = 'public/destinations/' . $destination->image;
            Storage::delete($path);
            $destination->delete();

            return response()->json([
                'message' => 'delete success',
                'statusCode' => 200,
                'data' => $destination
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e,
                'error' => 'Data tidak ditemukan',
                'statusCode' => 400,
                'data' => null
            ]);
        }
    }
}
