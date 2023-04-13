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
        $response = new Responses();
        try {
            $data = Checkout_instant_travel_sumary::all();
        foreach ($data as $key => $value) {
            $dataTransform[] = [
                "transaction_number" => $value->transaction_number,
                "Date" => Carbon::createFromTimestamp($value->created_at)->toDateTimeString(),
                "status" => "Success",
                "Category" => "Destination",
                "destination" => [
                    "name" => $value->palace->palace_name,
                    "tag" => $value->palace->tag->name,
                    "city" => $value->palace->city->name,
                    "province" => $value->palace->province->name,
                    "country" => $value->palace->country->name,
                ],
                "ticket_date" => $value->ticket_date,
                "qty" => $value->qty,
                "price" => $value->palace->price,
                "total_price" => $value->total_price,
                "firstname" => $value->firstname,
                "lastname" => $value->lastname,
                "email" => $value->email,
                "phone_number" => $value->phone_number
            ];
        }
         return $response->Response("success", $dataTransform, 200);
        } catch (\Throwable $th) {
           return $response->Response($th->getMessage(), null, 500);
        }
        
    }

    public function store(Request $request)
    {
        $response = new Responses();
        try {
            $checkout_instant_travel_sumary = $request->validate([
                'user_id' => 'required|numeric',
                'palace_id' => 'required|numeric',
                'total_price' => 'required|numeric',
                'firstname' => 'required|min:3|max:100',
                'lastname' => 'required|min:3|max:100',
                'email' => 'required|min:3|max:100',
                'phone_number' => 'required|min:3|max:13',
                'ticket_date' => 'required|date',
                'qty' => 'required|numeric'
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
        $response = new Responses();
        try {
            $checkdata = Checkout_instant_travel_sumary::find($id);
            if ($checkdata == null || $checkdata == []) {
                return $response->Response("Data Not Found", null, 404);
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

            return $response->Response("success", $checkout_instant_travel_sumary, 200);
        } catch (Exception $e) {
           return $response->Response("Data Not Found", null, 404);
        }
    }

    public function update(Request $request, $id)
    {
        $response = new Responses();
        try{
            $checkout_instant_travel_sumary = $request->validate([
                'user_id' => 'required|numeric',
                'palace_id' => 'required|numeric',
                'total_price' => 'required|numeric',
                'firstname' => 'required|min:3|max:100',
                'lastname' => 'required|min:3|max:100',
                'email' => 'required|min:3|max:100',
                'phone_number' => 'required|min:3|max:13',
                'ticket_date' => 'required|date',
                'qty' => 'required|numeric'
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

           return $response->Response("success", $data, 200);
        } catch(Exception $e) {
            return $response->Response($e->getMessage(), null, 400);
        }
    }

    public function destroy($id)
    {
        $response = new Responses();
        try {
            $checkout_instant_travel_sumary = Checkout_instant_travel_sumary::find($id);
            if ($checkout_instant_travel_sumary == null) {
                return $response->Response("Data Not Found", null, 404);
            }

            $checkout_instant_travel_sumary->delete();
            return $response->Response("success", $checkout_instant_travel_sumary, 200);
        } catch (Exception $e) {
            return $response->Response($e->getMessage(), null, 404);
        }
    }
}
