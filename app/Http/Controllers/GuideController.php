<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\Guide;
use Illuminate\Http\Request;

class GuideController extends Controller
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
        $response = new Responses();
        try {
            $data = Guide::all();
            return $response->Response("success", $data, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 500);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = new Responses();
        try {
            $isValidateData = $request->validate([
                "name" => 'required|min:3|max:100',
            ]);
            Guide::create($isValidateData);
            return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function edit(Guide $guide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guide $guide)
    {
        $response = new Responses();
        try {
            $isValidateData = $request->validate([
                "name" => 'required|min:3|max:100',
            ]);
            $guide->update($isValidateData);
            return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = new Responses();
        try {
            $getData = Guide::find($id);
            Guide::where('id', $id)->delete();
            return $response->Response("success", $getData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }
}
