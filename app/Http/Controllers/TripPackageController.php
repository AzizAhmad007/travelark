<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\TripPackage;
use App\Http\Requests\StoreTripPackageRequest;
use App\Http\Requests\UpdateTripPackageRequest;

class TripPackageController extends Controller
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
            $data = TripPackage::with('user', 'destination', 'guide')->get();
            foreach ($data as $key => $value) {

                $dataTransform[] = [
                    "id" => $value->id,
                    "created_by" => $value->user->fullname,
                    "type" => $value->type,
                    "destination_id" =>$value->destination->destination_name,
                    "guide_id" => $value->guide->name,
                    "duration" =>  $value->duration,
                    "price" => $value->price,
                    "quota" => $value->quota,
                    "departure_time" => $value->departure_time
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTripPackageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTripPackageRequest $request)
    {
         $response = new Responses;
        try {
            $isValidateData = $request->validate([
                "created_by" => 'required|numeric',
                "type" => 'required',
                "destination_id" => 'required',
                "guide_id" => 'required',
                "duration" => 'required',
                "quota" => 'required',
                "departure_time" => 'required',
                "price" => 'required|min:3|max:100',
            ]);
            TripPackage::create($isValidateData);
            return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TripPackage  $tripPackage
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = new Responses;
         $checkData  = TripPackage::find($id);
        if (!$checkData == []) {
            $setData = [
                    "id" => $checkData->id,
                    "created_by" => $checkData->user->fullname,
                    "type" => $checkData->type,
                    "destination_id" =>$checkData->destination->name,
                    "guide_id" => $checkData->guide->name,
                    "duration" =>  $checkData->duration,
                    "price" => $checkData->price,
                    "departure_time" => $checkData->departure_time,
                    "quota" => $checkData->quota
            ];
            return $response->Response("success", $setData, 200);
        } else {
           return $response->Response("Data Not Found", null, 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TripPackage  $tripPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(TripPackage $tripPackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTripPackageRequest  $request
     * @param  \App\Models\TripPackage  $tripPackage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTripPackageRequest $request, $id)
    {
        $response = new Responses;
        try {
            $isValidateData = $request->validate([
               "created_by" => 'required|numeric',
                "type" => 'required',
                "destination_id" => 'required',
                "guide_id" => 'required',
                "duration" => 'required',
                "quota" => 'required',
                "departure_time" => 'required',
                "price" => 'required|min:3|max:100',
            ]);
            $getData = TripPackage::find($id);
            $getData->created_by = $isValidateData["created_by"];
            $getData->type = $isValidateData["type"];
            $getData->destination_id = $isValidateData["destination_id"];
            $getData->guide_id = $isValidateData["guide_id"];
            $getData->duration = $isValidateData["duration"];         
            $getData->quota = $isValidateData["quota"];         
            $getData->departure_time = $isValidateData["departure_time"];         
            $getData->price = $isValidateData["price"];
            $getData->save();
           return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TripPackage  $tripPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $response = new Responses;
         try {
            $getData = TripPackage::find($id);
            TripPackage::where('id', $id)->delete();
            return $response->Response("success", $getData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }
}
