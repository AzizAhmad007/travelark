<?php

namespace App\Http\Controllers;

use App\Models\Checkout_instant_travel_sumary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class Checkout_instant_travel_sumaryController extends Controller
{
    public function index()
    {
        $checkout_instant_travel_sumary = Checkout_instant_travel_sumary::all();
        return $checkout_instant_travel_sumary;
    }

    public function store(Request $request)
    {
        try {
            $checkout_instant_travel_sumary = $request->validate([
                'user_id' => 'required',
                'instant_travel_id' => 'required',
                'total_price' => 'required',
                'checkout_id' => 'required'
            ]);

            Checkout_instant_travel_sumary::create($checkout_instant_travel_sumary);

            return response()->json([
                'message' => 'success',
                'statusCode' => 200,
                'data' => $checkout_instant_travel_sumary
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
            $checkdata = Checkout_instant_travel_sumary::find($id);
            if ($checkdata == null) {
                throw new Exception('Data tidak Ditemukan');
            } else {

                $checkout_instant_travel_sumary = [
                    'user_id' => $checkdata->user_id,
                    'instant_travel_id' => $checkdata->instant_travel_id,
                    'total_price' => $checkdata->total_price,
                    'checkout_id' => $checkdata->checkout_id
                ];
            }

            return response()->json([
                'message' => 'Data ditemukan',
                'statusCode' => 200,
                'data' => $checkout_instant_travel_sumary
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
        try{
            $checkout_instant_travel_sumary = $request->validate([
                'user_id' => 'required',
                'instant_travel_id' => 'required',
                'total_price' => 'required',
                'checkout_id' => 'required'
            ]);

            $checkout_instant_travel_sumary = Checkout_instant_travel_sumary::find($id);
            $data = $request->all();

            $checkout_instant_travel_sumary->update([
                'user_id' => $request->user_id,
                'instant_travel_id' => $request->instant_travel_id,
                'total_price' => $request->total_price,
                'checkout_id' => $request->checkout
            ]);

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
            $checkout_instant_travel_sumary = Checkout_instant_travel_sumary::find($id);
            if ($checkout_instant_travel_sumary == null) {
                throw new Exception('Data tidak ditemukan');
            }

            $checkout_instant_travel_sumary->delete();
            return response()->json([
                'message' => 'delete success',
                'statusCode' => 200,
                'data' => $checkout_instant_travel_sumary
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
