<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function index()
    {
        return response()->json([
            "message" => "success",
            "statusCode" => 200,
            "data" => Ticket::all(),
        ]);
    }
    public function create()
    {
        //
    }
    public function store(Request $request)
    {
        try {
            $isValidateData = $request->validate([
                "user_id" => 'required',
                "first_name" => 'required',
                "last_name" => 'required',
                "email" => 'required',
                "phone" => 'required',
                "message" => 'required'
            ]);
            Ticket::create($isValidateData);
            return response()->json([
                "message" => "success",
                'statusCode' => 200,
                "data" => $isValidateData,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                'statusCode' => 400,
                "data" => null
            ]);
        }
    }
    public function show($id)
    {
        try {
            $ticket = Ticket::find($id);
            if ($ticket == null) {
                throw new Exception('Data tidak ditemukan');
            }
            return $ticket;
            return response()->json([
                'message' => 'Data ditemukan',
                'statusCode' => 200,
                'data' => $ticket
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e,
                'statusCode' => 400,
                'data' => null
            ]);
        }
    }
    public function delete($id)
    {
        try {
            $getData = Ticket::find($id);
            Ticket::where('id', $id)->delete();
            return response()->json([
                "message" => "success",
                'statusCode' => 200,
                'data' => $getData
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                'statusCode' => 400,
                'data' => null
            ]);
        }
    }
}
