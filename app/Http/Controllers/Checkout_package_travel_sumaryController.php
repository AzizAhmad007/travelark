<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\Checkout_package_travel_sumary;
use App\Models\DetailPackage;
use App\Models\TripPackage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Checkout_package_travel_sumaryController extends Controller
{
    public function __construct()
    {
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
            $travelerPackage = DetailPackage::where("trip_packages_id", $data["trip_package_id"])->get();
            $count = count($travelerPackage);
            $tripPackage = TripPackage::where("id", $data["trip_package_id"])->first();
            if ($count > 0) {
                 $newArry = [];
                for ($i = 0; $i < $count; $i++) {
                    array_push($newArry, $travelerPackage[$i]->checkout_package->qty);
                }
                $sum = array_sum($newArry) + $data["qty"];
                if ($sum > $tripPackage->quota) {
                    return $response->Response("Quota Is Full", null, 500);
                } 
            }
            $transactionNumber = Str::random(10) . uniqid();
            $data['transaction_number'] = $transactionNumber;
            $getData = Checkout_package_travel_sumary::create($data);
            $insertDetailPackage = [
                "user_id" => $data['user_id'],
                "trip_packages_id" => $data["trip_package_id"],
                "checkout_package_id" => $getData->id,
            ];
            DetailPackage::create($insertDetailPackage);
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

            $data = Checkout_package_travel_sumary::find($id);
            $data->user_id = $request->user_id;
            $data->firstname = $request->firstname;
            $data->lastname = $request->lastname;
            $data->email = $request->email;
            $data->phone_number = $request->phone_number;
            $data->save();

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
            $data->delete();

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
