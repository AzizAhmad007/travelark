<?php

namespace App\Http\Controllers;

use App\Models\Destination_detail;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Responses\Responses;
use Illuminate\Http\Request;
use Exception;

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
            return $response->Response("Success", $destination_detail, 200);
        }
    }

    public function store(Request $request)
    {
        $response = new Responses;
        try {
            $destination_detail = $request->validate([
                'name' => 'required',
                'destination_id' => 'required'
            ]);

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
        try {
            $destination_detail = Destination_detail::find($id);
            if ($destination_detail == null) {
                throw new Exception('Data tidak ditemukan');
            }
            $destination_detail = Destination_detail::find($id);
            $destination_detail->delete();

            return response()->json([
                'message' => 'delete success',
                'statusCode' => 200,
                'data' => $destination_detail
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
