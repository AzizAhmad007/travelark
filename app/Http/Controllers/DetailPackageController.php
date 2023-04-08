<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\DetailPackage;
use Exception;
use Illuminate\Http\Request;

class DetailPackageController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function index()
    {
        $data = DetailPackage::all();
        return $data;
    }

    public function store(Request $request)
    {
        $response = new Responses;
        try {
            $data = $request->validate([
                'user_id'=>'required',
                'trip_packages_id'=>'required',
                'checkout_package_id'=>'required',
            ]);

            DetailPackage::create($data);

            return $response->Response("success", $data, 200);
        } catch (Exception $e) {
           return $response->Response($e->getMessage(), null, 400);
        }
    }

    public function show($id)
    {
        $data = DetailPackage::find($id);
        if ($data === null || $data === []) {
            return response()->json([
                'message' => 'data not found'
            ]);
        } else {
            return $data;
        }
    }

    public function update(Request $request, $id)
    {
        $response = new Responses;
        try {
            $isValidate = $request->validate([
                'user_id'=>'required',
                'trip_packages_id'=>'required',
                'checkout_package_id'=>'required',
            ]);

            $data = DetailPackage::find($id);
            $data->user_id = $isValidate["user_id"];
            $data->trip_packages_id = $isValidate["trip_packages_id"];
            $data->checkout_package_id = $isValidate["checkout_package_id"];
            $data->save();

            return $response->Response("success", $data, 200);
        } catch (Exception $e) {
            return $response->Response($e->getMessage(), null, 400);
        }
    }

    public function delete($id)
    {
        $response = new Responses;
        try {
            $data = DetailPackage::find($id);
            $data -> delete();

            return $response->Response("success", $data, 200);
        } catch (Exception $e) {
           return $response->Response($e->getMessage(), null, 400);
        }
    }
}
