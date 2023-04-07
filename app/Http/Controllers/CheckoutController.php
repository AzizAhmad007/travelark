<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Exception;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function index()
    {
        $data = Checkout::all();
        return $data;
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'phone_number' => 'required|min:10|max:13'
            ]);

            Checkout::create($data);

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
        $data = Checkout::find($id);
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
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'phone_number' => 'required|min:10|max:13'
            ]);

            $data = Checkout::find($id);
            $data -> user_id = $request -> user_id;
            $data -> firstname = $request -> firstname;
            $data -> lastname = $request -> lastname;
            $data -> email = $request -> email;
            $data -> phone_number = $request -> phone_number;
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
            $data = Checkout::find($id);
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
