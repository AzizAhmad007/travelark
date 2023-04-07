<?php

namespace App\Http\Controllers;

use App\Models\Destination_detail;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Responses\Responses;
use App\Models\Destination;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Storage;

class Destination_detailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function index()
    {
        $destination_detail = Destination_detail::all();
        return $destination_detail;
    }

    public function show($id)
    {
        $response = new Responses;
        $destination_detail = Destination_detail::find($id);
        if ($destination_detail == null || $destination_detail === []) {
            return $response->Response("Data Not Found", null, 404);
        } else {
            $imageContent = Storage::get($destination_detail->image);
            $setData = [
                "id" => $destination_detail->id,
                "destination" => Destination::where('id', $destination_detail->destination_id),
                "image" => base64_encode($imageContent),
            ];
            return $response->Response("Success", $destination_detail, 200);
        }
    }

    public function store(Request $request)
    {
        $response = new Responses;
        try {
            $destination_detail = $request->validate([
                'name' => 'required',
                'destination_id' => 'required',
                "image" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $image = $request->file('image');
            $path = $image->store('public/destinations');
            $isValidateData['image'] = $path;
            Destination_detail::create($destination_detail);
            return $response->Response("Success", $destination_detail, 200);
        } catch (Exception $e) {
            return $response->Response($e->getMessage(), null, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $response = new Responses;
        try {
            $destination_detail = $request->validate([
                'name' => 'required',
                'destination_id' => 'required',
                "image" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $destination_detail = Destination_detail::find($id);
            $data = $request->all();
            $destination_detail->update($data);

            return $response->Response("Success", $data, 200);
        } catch (Exception $e) {
            return $response->Response($e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        $response = new Responses;
        try {
            $destination_detail = Destination_detail::find($id);
            if ($destination_detail == null) {
                return $response->Response("Data Not Found", null, 404);
            }
            $destination_detail->delete();
            $path = $destination_detail->image;
            Storage::delete($path);

             return $response->Response("success", $destination_detail, 200);
        } catch (Exception $e) {
           return $response->Response($e, null, 400);
        }
    }
}
