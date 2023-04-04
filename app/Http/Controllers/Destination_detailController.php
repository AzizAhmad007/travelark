<?php

namespace App\Http\Controllers;

use App\Models\Destination_detail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;

class Destination_detailController extends Controller
{
    public function index()
    {
        $destination_detail = Destination_detail::all();
        return $destination_detail;
    }

    public function show($id)
    {
        try {
            $destination_detail = Destination_detail::find($id);
            if ($destination_detail == null) {
                throw new Exception('Data tidak ditemukan');
            }
            return $destination_detail;

            return response()->json([
                'message' => 'Data ditemukan',
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

    public function store(Request $request)
    {
        try {
            $destination_detail = $request->validate([
                'name' => 'required',
                'destination_id' => 'required'
            ]);

            Destination_detail::create($destination_detail);

            return response()->json([
                'message' => 'success',
                'statusCOde' => 200,
                "data" => $destination_detail
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

    public function update (Request $request, $id)
    {
        try {
            $destination_detail = $request->validate([
                'name' => 'required',
                'destination_id' => 'required',
            ]);

            $destination_detail = Destination_detail::find($id);
            $data = $request->all();
            $destination_detail->update($data);

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
