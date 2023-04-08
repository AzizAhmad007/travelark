<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\Checkout_package_travel_sumary;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Checkout_package_travel_sumaryController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function index()
    {
        $data = Checkout_package_travel_sumary::all();
        return $data;
    }

    public function store(Request $request)
    {
        $response = new Responses;
        try {
            $data = $request->validate([
                'user_id' => 'required',
                'trip_package_id' => 'required',
                'total_price' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'phone_number' => 'required',
                'ticket_date' => 'required',
                'qty' => 'required'
            ]);
            $transactionNumber = Str::random(10).uniqid();
            $data['transaction_number'] = $transactionNumber;
            $getData = Checkout_package_travel_sumary::create($data);
             $res = [
                "transaction_number" => $getData->transaction_number,
                "Date" => $getData->trip_package->departure_time,
                "status" => "Success",
                "Category" => $getData->trip_package->type,
                "destination" => [
                    "name" => $getData->trip_package->destination->destination_name,
                    "tag" => $getData->trip_package->destination->tag->name,
                    "city" => $getData->trip_package->destination->city->name,
                    "province" => $getData->trip_package->destination->province->name,
                    "country" => $getData->trip_package->destination->country->name,
                ],
                "ticket_date" => $getData->ticket_date,
                "qty" => $getData->qty,
                "price" => $getData->trip_package->destination->price,
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
        $data = Checkout_package_travel_sumary::find($id);
        if ($data === null || $data === []) {
            return response()->json(['message' => 'data not found']);
        } else {
            $res = [
                "transaction_number" => $data->transaction_number,
                "Date" => $data->trip_package->departure_time,
                "status" => "Success",
                "Category" => $data->trip_package->type,
                "destination" => [
                    "name" => $data->trip_package->destination->destination_name,
                    "tag" => $data->trip_package->destination->tag->name,
                    "city" => $data->trip_package->destination->city->name,
                    "province" => $data->trip_package->destination->province->name,
                    "country" => $data->trip_package->destination->country->name,
                ],
                "ticket_date" => $data->ticket_date,
                "qty" => $data->qty,
                "price" => $data->trip_package->destination->price,
                "total_price" => $data->total_price,
                "firstname" => $data->firstname,
                "lastname" => $data->lastname,
                "email" => $data->email,
                "phone_number" => $data->phone_number
            ];
            return response()->json([
                'message' => 'success',
                'data' => $res
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'trip_package_id' => 'required',
                'total_price' => 'required',
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required',
                'phone_number' => 'required',
                'ticket_date' => 'required',
                'qty' => 'required'
            ]);

            $data = Checkout_package_travel_sumary::find($id);
            $data -> user_id = $request -> user_id;
            $data -> trip_package_id = $request -> trip_package_id;
            $data -> total_price = $request -> total_price;
            $data -> firstname = $request -> firstname;
            $data -> lastname = $request -> lastname;
            $data -> email = $request -> email;
            $data -> phone_number = $request -> phone_number;
            $data -> ticket_date = $request -> ticket_date;
            $data -> qty = $request -> qty;
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
            $data = Checkout_package_travel_sumary::find($id);
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
