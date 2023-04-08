<?php

namespace App\Http\Controllers;

use App\Models\Checkout_instant_travel_sumary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Responses\Responses;
use App\Models\Palace;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;

class Checkout_instant_travel_sumaryController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        
    }
    public function index()
    {
        $checkout_instant_travel_sumary = Checkout_instant_travel_sumary::all();
        return $checkout_instant_travel_sumary;
    }

    public function store(Request $request)
    {
        $response = new Responses;
        try {
            $checkout_instant_travel_sumary = $request->validate([
                'user_id' => 'required',
                'palace_id' => 'required',
                'total_price' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'phone_number' => 'required',
                'ticket_date' => 'required',
                'qty' => 'required'
            ]);
            $transactionNumber = Str::random(10).uniqid();
            $checkout_instant_travel_sumary['transaction_number'] = $transactionNumber;
            $getData = Checkout_instant_travel_sumary::create($checkout_instant_travel_sumary);

            $res = [
                "transaction_number" => $getData->transaction_number,
                "Date" => Carbon::createFromTimestamp($getData->created_at)->toDateTimeString(),
                "status" => "Success",
                "Category" => "Destination",
                "destination" => [
                    "name" => $getData->palace->palace_name,
                    "tag" => $getData->palace->tag->name,
                    "city" => $getData->palace->city->name,
                    "province" => $getData->palace->province->name,
                    "country" => $getData->palace->country->name,
                ],
                "ticket_date" => $getData->ticket_date,
                "qty" => $getData->qty,
                "price" => $getData->palace->price,
                "total_price" => $getData->total_price,
                "firstname" => $getData->firstname,
                "lastname" => $getData->lastname,
                "email" => $getData->email,
                "phone_number" => $getData->phone_number
            ];

            return $response->Response("success", $res, 200);
        } catch (Exception $e) {
           return $response->Response($e->getMessage(), null, 400);
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
                    "transaction_number" => $checkdata->transaction_number,
                    "Date" => Carbon::createFromTimestamp($checkdata->created_at)->toDateTimeString(),
                    "status" => "Success",
                    "Category" => "Destination",
                    "destination" => [
                        "name" => $checkdata->palace->palace_name,
                        "tag" => $checkdata->palace->tag->name,
                        "city" => $checkdata->palace->city->name,
                        "province" => $checkdata->palace->province->name,
                        "country" => $checkdata->palace->country->name,
                    ],
                    "ticket_date" => $checkdata->ticket_date,
                    "qty" => $checkdata->qty,
                    "price" => $checkdata->palace->price,
                    "total_price" => $checkdata->total_price,
                    "firstname" => $checkdata->firstname,
                    "lastname" => $checkdata->lastname,
                    "email" => $checkdata->email,
                    "phone_number" => $checkdata->phone_number
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
                'palace_id' => 'required',
                'total_price' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'phone_number' => 'required',
                'ticket_date' => 'required',
                'qty' => 'required'
            ]);

            $checkout_instant_travel_sumary = Checkout_instant_travel_sumary::find($id);
            $data = $request->all();

            $checkout_instant_travel_sumary->update([
                'user_id' => $request->user_id,
                'palace_id' => $request->palace_id,
                'total_price' => $request->total_price,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'ticket_date' => $request->ticket_date,
                'qty' => $request->qty,
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
