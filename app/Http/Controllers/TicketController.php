<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
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
        $response = new Responses;
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
           return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
           return $response->Response($th->getMessage(), null, 400);
        }
    }
    public function show($id)
    {
        $response = new Responses;
            $ticket = Ticket::find($id);
            if ($ticket == null || $ticket === []) {
                return $response->Response("Data Not Found", null, 404);
            }else {
                return $response->Response("success", $ticket, 200);
            }
    }
    public function delete($id)
    {
        $response = new Responses;
        try {
            $getData = Ticket::find($id);
            Ticket::where('id', $id)->delete();
            return $response->Response("success", $getData, 200);
        } catch (\Throwable $th) {
            return $response->Response("Data Not Found", null, 404);
        }
    }
}
