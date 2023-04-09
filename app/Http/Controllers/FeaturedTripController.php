<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\FeaturedTrip;
use Illuminate\Http\Request;

class FeaturedTripController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
     public function index()
    {
         $response = new Responses;
        try {
            $data = FeaturedTrip::with('trip_package')->get();
            foreach ($data as $key => $value) {

                $dataTransform[] = [
                    "id" => $value->id,
                    "name" => $value->name,
                    "trip_package" => $value->trip_package,
                ];
            }
           return $response->Response("success", $dataTransform, 200);
        } catch (\Throwable $th) {
           return $response->Response($th->getMessage(), null, 500);
        }
    }

    public function store(Request $request)
    {
        $response = new Responses;
        try {
            $isValidateData = $request->validate([
                "name" => 'required|min:3|max:100',
                "trip_package_id" => 'required|numeric',
            ]);
            FeaturedTrip::create($isValidateData);
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
                "name" => 'required|min:3|max:100',
                "trip_package_id" => 'required|numeric',
             ]);
            $getData = FeaturedTrip::find($id);
            $getData->name = $isValidateData["name"];
            $getData->trip_package_id = $isValidateData["trip_package_id"];
            $getData->save();
           return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

     public function destroy($id)
    {
         $response = new Responses;
        try {
            $getData = FeaturedTrip::find($id);
            FeaturedTrip::where('id', $id)->delete();
            return $response->Response("success", $getData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }
}
