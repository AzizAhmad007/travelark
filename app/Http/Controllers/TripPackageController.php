<?php

namespace App\Http\Controllers;

use App\Models\TripPackage;
use App\Http\Requests\StoreTripPackageRequest;
use App\Http\Requests\UpdateTripPackageRequest;

class TripPackageController extends Controller
{
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
                    "created_id" => $value->user->fullname,
                    "type" => $value->type,
                    "destination_id" =>$value->destination->name,
                    "guide_id" => $value->guide->name,
                    "duration" =>  $value->duration,
                    "price" => $value->price
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
        try {
            $isValidateData =
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TripPackage  $tripPackage
     * @return \Illuminate\Http\Response
     */
    public function show(TripPackage $tripPackage)
    {
        //
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
    public function update(UpdateTripPackageRequest $request, TripPackage $tripPackage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TripPackage  $tripPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(TripPackage $tripPackage)
    {
        //
    }
}
