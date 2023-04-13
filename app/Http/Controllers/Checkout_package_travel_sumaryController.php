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
        $response = new Responses();
        try {
            $data = Checkout_package_travel_sumary::all();
        foreach ($data as $key => $value) {
            $dataTransform[] = [
                "transaction_number" => $value->transaction_number,
                "Date" => $value->trip_package->departure_time,
                "status" => "Success",
                "Category" => $value->trip_package->type,
                "destination" => [
                    "name" => $value->trip_package->destination->destination_name,
                    "tag" => $value->trip_package->destination->tag->name,
                    "city" => $value->trip_package->destination->city->name,
                    "province" => $value->trip_package->destination->province->name,
                    "country" => $value->trip_package->destination->country->name,
                ],
                "ticket_date" => $value->ticket_date,
                "qty" => $value->qty,
                "price" => $value->trip_package->destination->price,
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
            $data = $request->validate([
                'user_id' => 'required|numeric',
                'trip_package_id' => 'required|numeric',
                'total_price' => 'required|numeric',
                'firstname' =>'required|min:3|max:100',
                'lastname' =>'required|min:3|max:100',
                'email' =>'required|min:3|max:100',
                'phone_number' =>'required|min:3|max:13',
                'ticket_date' => 'required|date',
                'qty' => 'required|numeric'
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
        $response = new Responses();
        $data = Checkout_package_travel_sumary::find($id);
        if ($data === null || $data === []) {
           return $response->Response("Data Not Found", null, 404);
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
          return $response->Response("success", $res, 200);
        }
    }
    public function update(Request $request, $id)
    {
        $response = new Responses();
        try {
            $request->validate([
                'user_id' => 'required|numeric',
                'trip_package_id' => 'required|numeric',
                'total_price' => 'required|numeric',
                'firstname' =>'required|min:3|max:100',
                'lastname' =>'required|min:3|max:100',
                'email' =>'required|min:3|max:100',
                'phone_number' =>'required|min:3|max:13',
                'ticket_date' => 'required|date',
                'qty' => 'required|numeric'
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

            return $response->Response("success", $data, 200);
        } catch (Exception $e) {
           return $response->Response($e->getMessage(), null, 400);
        }
    }

    public function delete($id)
    {
        $response = new Responses();
        try {
            $data = Checkout_package_travel_sumary::find($id);
            $data->delete();

            return $response->Response("success", $data, 200);
        } catch (Exception $e) {
            return $response->Response($e->getMessage(), null, 400);
        }
    }
}
