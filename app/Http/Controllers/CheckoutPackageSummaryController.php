<?php

namespace App\Http\Controllers;

use App\Models\CheckoutPackageSummary;
use Exception;
use Illuminate\Http\Request;

class CheckoutPackageSummaryController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function index()
    {
        $data = CheckoutPackageSummary::all();
        return $data;
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required',
                'detail_package_id' => 'required',
                'total_price' => 'required',
                'checkout_id' => 'required'
            ]);

            CheckoutPackageSummary::create($data);

            return response()->json([
                'message' => 'success',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e,
            ]);
        }
    }
    public function show($id)
    {
        $data = CheckoutPackageSummary::find($id);
        if ($data === null || $data === []) {
            return response()->json(['message' => 'data not found']);
        } else {
            return $data;
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'detail_package_id' => 'required',
                'total_price' => 'required',
                'checkout_id' => 'required'
            ]);

            $data = CheckoutPackageSummary::find($id);
            $data -> user_id = $request -> user_id;
            $data -> detail_package_id = $request -> detail_package_id;
            $data -> total_price = $request -> total_price;
            $data -> checkout_id = $request -> checkout_id;
            $data -> save();

            return response()->json([
                'message' => 'success',
                'data' => $data
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e,
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $data = CheckoutPackageSummary::find($id);
            $data -> delete();

            return response()->json([
                'message' => 'success',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'error' => $e,
            ]);
        }
    }
}
