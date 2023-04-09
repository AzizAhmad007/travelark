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
        $response = new Responses;
        try {
            $data = DetailPackage::with('user', 'trip_package', 'checkout_package')->get();
            foreach ($data as $key => $value) {
                $dataTransform[] = [
                'user_id' => $value->user->username,
                'trip_packages_id' => $value->trip_package->type,
                'checkout_package_id' => $value->checkout_package->transaction_number,
                ];
            }
             return $response->Response("Success", $dataTransform, 200);
        } catch (\Throwable $th) {
             return $response->Response($th->getMessage(), null, 500);
        }
    }

    public function store(Request $request)
    {
        $response = new Responses;
        try {
            $data = $request->validate([
                'user_id'=>'required|numeric',
                'trip_packages_id'=>'required|numeric',
                'checkout_package_id'=>'required|numeric',
            ]);

            DetailPackage::create($data);

            return $response->Response("success", $data, 200);
        } catch (Exception $e) {
           return $response->Response($e->getMessage(), null, 400);
        }
    }

    public function show($id)
    {
        $response = new Responses;
        $data = DetailPackage::find($id);
        if ($data === null || $data === []) {
            return $response->Response("Data Not Found", null, 404);
        } else {
            return $response->Response("success", $data, 200);
        }
    }

    public function update(Request $request, $id)
    {
        $response = new Responses;
        try {
            $isValidate = $request->validate([
                'user_id'=>'required|numeric',
                'trip_packages_id'=>'required|numeric',
                'checkout_package_id'=>'required|numeric',
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
