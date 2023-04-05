<?php

namespace App\Http\Controllers;

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
        try {
            $data = $request->validate([
                'user_id'=>'required',
                'description'=>'required',
                'quota'=>'required',
                'departure_time'=>'required',
                'total_price'=>'required',
                'trip_package_id'=>'required'
            ]);

            DetailPackage::create($data);

            return response()->json([
                'message' => 'data berhasil dimasukkan',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'terjadi kesalahan',
                'error' => $e,
                // 'msg' => $e->getMessage(),
            ]);
        }
    }

    public function show($id)
    {
        $data = DetailPackage::find($id);
        return $data;
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'user_id'=>'required',
                'description'=>'required',
                'quota'=>'required',
                'departure_time'=>'required',
                'total_price'=>'required',
                'trip_package_id'=>'required'
            ]);

            $data = DetailPackage::find($id);
            $data -> user_id = $request -> user_id;
            $data -> description = $request -> description;
            $data -> quota = $request -> quota;
            $data -> departure_time = $request -> departure_time;
            $data -> total_price = $request -> total_price;
            $data -> trip_package_id = $request -> trip_package_id;
            $data -> save();

            return response()->json([
                'message' => 'data berhasil diperbarui',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'terjadi kesalahan',
                'error' => $e,
                // 'msg' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $data = DetailPackage::find($id);
            $data -> delete();

            return response()->json([
                'message' => 'data berhasil terhapus'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'terjadi kesalahan',
                'error' => $e,
                // 'msg' => $e->getMessage(),
            ]);
        }
    }
}
