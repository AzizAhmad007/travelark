<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\Trip_AcomodationModel;
use Illuminate\Http\Request;

class Trip_AcomodationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Trip_AcomodationModel::with('trip_package')->get();
            foreach ($data as $key => $value) {

                $dataTransform[] = [
                    "id" => $value->id,
                    "name" => $value->name,
                    "trip_package" => $value->trip_package,
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = new Responses;
        try {
            $isValidateData = $request->validate([
                "name" => 'required',
                "trip_package_id" => 'required',
            ]);
            Trip_AcomodationModel::create($isValidateData);
            return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $response = new Responses;
        $checkData  = Trip_AcomodationModel::find($id);
        if (!$checkData == []) {
            $setData = [
                    "id" => $checkData->id,
                    "name" => $checkData->name,
                    "trip_package" => $checkData->trip_package_id,
                ];
            return $response->Response("success", $setData, 200);
        } else {
            return $response->Response("Data Not Found", null, 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $response = new Responses;
        try {
            $isValidateData = $request->validate([
                "name" => 'required',
                "trip_package_id" => 'required',
             ]);
            $getData = Trip_AcomodationModel::find($id);
            $getData->name = $isValidateData["name"];
            $getData->trip_package_id = $isValidateData["trip_package_id"];
            $getData->save();
           return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $response = new Responses;
        try {
            $getData = Trip_AcomodationModel::find($id);
            Trip_AcomodationModel::where('id', $id)->delete();
            return $response->Response("success", $getData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }
}
