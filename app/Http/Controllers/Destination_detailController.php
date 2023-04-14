<?php

namespace App\Http\Controllers;

use App\Models\Destination_detail;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Responses\Responses;
use App\Models\Destination;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Storage;
use Module\imageCompress\ImageCompress;

class Destination_detailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function index()
    {
        $response = new Responses();
        try {
            $data = Destination_detail::with('destination')->get();
            foreach ($data as $key => $value) {
                $compress = new ImageCompress();
                $image = $compress->getImage($value->image);
                $dataTransform[] = [
                    "id" => $value->id,
                    "name" => $value->name,
                    "detination" => $value->destination->destination_name, 
                    "image" => $image,
                ];
            }
             return $response->Response("Success", $dataTransform, 200);
        } catch (\Throwable $th) {
             return $response->Response($th->getMessage(), null, 500);
        }
         
    }

    public function show($id)
    {
        $response = new Responses();
        $destination_detail = Destination_detail::find($id);
        if ($destination_detail == null || $destination_detail === []) {
            return $response->Response("Data Not Found", null, 404);
        } else {
            $compress = new ImageCompress();
            $image = $compress->getImage($destination_detail->image);
            $setData = [
                "id" => $destination_detail->id,
                "name" => $destination_detail->name,
                "destination" => $destination_detail->destination->destination_name,
                "image" => $image,
            ];
            return $response->Response("Success", $setData, 200);
        }
    }

    public function store(Request $request)
    {
        $response = new Responses();
        try {
            $destination_detail = $request->validate([
                'name' => 'required|min:3|max:100',
                'destination_id' => 'required|numeric',
                "image" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $image = $request->file('image');
             $compress = new ImageCompress();
            $imageAfterCompress = $compress->compress($image);
            $imeg = $compress->store("storage/destinations/",$imageAfterCompress);
            $destination_detail['image'] = $imeg;
            Destination_detail::create($destination_detail);
            return $response->Response("Success", $destination_detail, 200);
        } catch (Exception $e) {
            return $response->Response($e->getMessage(), null, 500);
        }
    }

    public function update(Request $request, $id)
    {
        $response = new Responses();
        try {
            $isValidate = $request->validate([
                'name' => 'required|min:3|max:100',
                'destination_id' => 'required|numeric',
                "image" => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $destination_detail = Destination_detail::find($id);
            $image = $request->file('image');
            $compress = new ImageCompress();
            $imageAfterCompress = $compress->compress($image);
            $imeg = $compress->store("storage/destinations/",$imageAfterCompress);
            $pathDelete = $destination_detail->image;
            unlink($pathDelete);
            $destination_detail->name = $isValidate["name"];
            $destination_detail->destination_id = $isValidate["destination_id"];
            $destination_detail->image = $imeg;
            $destination_detail->save();

            return $response->Response("Success", $isValidate, 200);
        } catch (Exception $e) {
            return $response->Response($e->getMessage(), null, 500);
        }
    }

    public function destroy($id)
    {
        $response = new Responses();
        try {
            $destination_detail = Destination_detail::find($id);
            if ($destination_detail == null) {
                return $response->Response("Data Not Found", null, 404);
            }
            $destination_detail->delete();
            $path = $destination_detail->image;
            unlink($path);

             return $response->Response("success", $destination_detail, 200);
        } catch (Exception $e) {
           return $response->Response($e, null, 400);
        }
    }
}
