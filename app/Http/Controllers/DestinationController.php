<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class DestinationController extends Controller
{
    public function index()
    {
        $destination = Destination::all();
        return $destination;
    }

    public function store(Request $request)
    {
        try {
            $destination = $request->validate([
                'user_id' => 'required',
                'tag_id' => 'required',
                'country_id' => 'required',
                'city_id' => 'required',
                'province_id' => 'required',
                'destination_name' => 'required',
                'image' => 'required',
                'price' => 'required',
                'description' => 'required',
                'private_price' => 'required'
            ]);
            Destination::create($destination);

            return response()->json([
                'message' => 'success',
                'statusCOde' => 200,
                "data" => $destination
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e,
                //'error' => $e->getMessage(),
                'error' => 'Terjadi kesalahan',
                'statusCode' => 400,
                'data' => null
            ]);
        }
    }

    public function show($id)
    {
        try {
            $destination = Destination::find($id);
            if ($destination == null) {
                throw new Exception('Data tidak ditemukan');
            }
            return $destination;

            return response()->json([
                'message' => 'Data ditemukan',
                'statusCode' => 200,
                'data' => $destination
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

    public function update(Request $request, $id)
    {
        try {
            $destination = $request->validate([
                'user_id' => 'required',
                'tag_id' => 'required',
                'country_id' => 'required',
                'city_id' => 'required',
                'province_id' => 'required',
                'destination_name' => 'required',
                'image' => 'required',
                'price' => 'required',
                'description' => 'required',
                'private_price' => 'required'
            ]);

            $destination = Destination::find($id);
            $data = $request->all();
            $destination->update($data);

            return response()->json([
                'message' => 'update success',
                'statusCode' => 200,
                'data' => $data
            ]);
        } catch(Exception $e) {
            return response()->json([
                'message' => $e,
                //'error' => $e->getMessage(),
                'error' => 'Terjadi kesalahan',
                'statusCode' => 400,
                'data' => null
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $destination = Destination::find($id);
            if ($destination == null) {
                throw new Exception('Data tidak ditemukan');
            }
            $destination = Destination::find($id);
            $destination->delete();

            return response()->json([
                'message' => 'delete success',
                'statusCode' => 200,
                'data' => $destination
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
