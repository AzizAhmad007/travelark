<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\Checkout_instant_travel_sumary;
use App\Models\Checkout_package_travel_sumary;
use App\Models\Destination_detail;
use App\Models\DetailPackage;
use App\Models\FeaturedTrip;
use App\Models\InstantTravelModel;
use App\Models\Palace;
use App\Models\Ticket;
use App\Models\Trip_AcomodationModel;
use App\Models\TripPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GuestController extends Controller
{
    public function getAllInstantTravel()
    {
        $response = new Responses;
        try {
            $data = Palace::with('user', 'tag', 'country', 'city', 'province')->get();
            foreach ($data as $key => $value) {
                $imageContent = Storage::get($value->image);
                $dataTransform[] = [
                    "id" => $value->id,
                    "tag_id" => $value->tag->name,
                    "country_id" => $value->country->name,
                    "city_id" => $value->city->name,
                    "province_id" => $value->province->name,
                    "palace_name" => $value->palace_name,
                    "image" => base64_encode($imageContent),
                ];
            }
            return $response->Response("success", $dataTransform, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 500);
        }
    }

    public function instatTravelDetail($id)
    {
        $response = new Responses;
        $checkData  = Palace::find($id);
        $show = Checkout_instant_travel_sumary::where('palace_id', $checkData->id)->get();
        $totalShow = count($show);
        if (!$checkData == []) {
            $imageContent = Storage::get($checkData->image);

            $setData = [
                "id" => $checkData->id,
                "tag_id" => $checkData->tag->name,
                "country_id" => $checkData->country->name,
                "city_id" => $checkData->city->name,
                "province_id" => $checkData->province->name,
                "palace_name" => $checkData->palace_name,
                "image" => base64_encode($imageContent),
                "price" => $checkData->price,
                "description" => $checkData->description,
                "showing" => $totalShow,
                "rating" => 5,
                "all_image" => InstantTravelModel::where("palace_id", $id)->pluck('image')
            ];
            return $response->Response("success", $setData, 200);
        } else {
            return $response->Response("Data Not Found", null, 404);
        }
    }

    public function package()
    {
        $response = new Responses;
        try {
            $data = TripPackage::with('user', 'destination', 'guide')->get();
            foreach ($data as $key => $value) {
                $travelerPackage = DetailPackage::where("trip_packages_id", $value->id)->get();
                $count = count($travelerPackage);
                if ($count == 0) {
                    $paxAvailable = 0;
                } else {
                    $newArry = [];
                    for ($i = 0; $i < count($travelerPackage); $i++) {
                        array_push($newArry, $travelerPackage[$i]->checkout_package->qty);
                    }
                    $sum = array_sum($newArry);
                    if ($value->quota > $sum) {
                        $paxAvailable = $value->quota - $sum;
                    } else {
                        $paxAvailable = 0;
                    }
                }
                $imageContent = Storage::get($value->destination->image);
                $dataTransform[] = [
                    "id" => $value->id,
                    "type" => $value->type,
                    "pax_available" => $paxAvailable,
                    "destination" => [
                        "tag" => $value->destination->tag->name,
                        "country" => $value->destination->country->name,
                        "city" => $value->destination->city->name,
                        "province" => $value->destination->province->name,
                        "image" => base64_encode($imageContent),
                        "destination_name" => $value->destination->destination_name,
                    ],
                ];
            }
            return $response->Response("success", $dataTransform, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }
    public function openPackage()
    {
        $response = new Responses;
        try {
            $data = TripPackage::where('type', 'open')->get();
            foreach ($data as $key => $value) {
                $travelerPackage = DetailPackage::where("trip_packages_id", $value->id)->get();
                $count = count($travelerPackage);
                if ($count == 0) {
                    $paxAvailable = 0;
                } else {
                    $newArry = [];
                    for ($i = 0; $i < count($travelerPackage); $i++) {
                        array_push($newArry, $travelerPackage[$i]->checkout_package->qty);
                    }
                    $sum = array_sum($newArry);
                    if ($value->quota > $sum) {
                        $paxAvailable = $value->quota - $sum;
                    } else {
                        $paxAvailable = 0;
                    }
                }
                $imageContent = Storage::get($value->destination->image);
                $dataTransform[] = [
                    "id" => $value->id,
                    "type" => $value->type,
                    "pax_available" => $paxAvailable,
                    "destination" => [
                        "tag" => $value->destination->tag->name,
                        "country" => $value->destination->country->name,
                        "city" => $value->destination->city->name,
                        "province" => $value->destination->province->name,
                        "image" => base64_encode($imageContent),
                        "destination_name" => $value->destination->destination_name,
                    ],
                ];
            }
            return $response->Response("success", $dataTransform, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

    public function privatepackage()
    {
        $response = new Responses;
        try {
            $data = TripPackage::where('type', 'private')->get();
            foreach ($data as $key => $value) {
                $imageContent = Storage::get($value->destination->image);
                $dataTransform[] = [
                    "id" => $value->id,
                    "type" => $value->type,
                    "destination" => [
                        "tag" => $value->destination->tag->name,
                        "country" => $value->destination->country->name,
                        "city" => $value->destination->city->name,
                        "province" => $value->destination->province->name,
                        "image" => base64_encode($imageContent),
                        "destination_name" => $value->destination->destination_name,
                    ],
                ];
            }
            return $response->Response("success", $dataTransform, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }



    public function privatePackageDestinationDetail($id)
    {
        $response = new Responses;
        $checkData  = TripPackage::find($id);
        $show = Checkout_package_travel_sumary::where('trip_package_id', $checkData->id)->get();
        $totalShow = count($show);
        if (!$checkData == []) {
            $imageContent = Storage::get($checkData->destination->image);


            $setData = [
                "id" => $checkData->id,
                "type" => $checkData->type,
                "duration" => $checkData->duration,
                "price" => $checkData->price,
                "quota" => $checkData->quota,
                "review" => $totalShow,
                "rating" => 5,
                "destination" => [
                    "tag" => $checkData->destination->tag->name,
                    "country" => $checkData->destination->country->name,
                    "city" => $checkData->destination->city->name,
                    "province" => $checkData->destination->province->name,
                    "image" => base64_encode($imageContent),
                    "destination_name" => $checkData->destination->destination_name,
                    "description" => $checkData->destination->description,
                    "all_image" => Destination_detail::where('destination_id', $checkData->destination_id)->pluck('image'),
                ],
                "featured_trip" => FeaturedTrip::where("trip_package_id", $checkData->id)->pluck('name'),
                "acomodation" => Trip_AcomodationModel::where('trip_package_id', $checkData->id)->pluck('name'),
                "destination_trip" => Destination_detail::where('destination_id', $checkData->destination_id)->pluck('name')

            ];
            return $response->Response("success", $setData, 200);
        } else {
            return $response->Response("Data Not Found", null, 404);
        }
    }
    public function openPackageDestinationDetail($id)
    {
        $response = new Responses;
        $checkData  = TripPackage::find($id);
        $show = Checkout_package_travel_sumary::where('trip_package_id', $checkData->id)->get();
        $totalShow = count($show);
        if (!$checkData == []) {
            $imageContent = Storage::get($checkData->destination->image);
            $travelerPackage = DetailPackage::where("trip_packages_id", $checkData->id)->get();
            $count = count($travelerPackage);
            if ($count == 0) {
                $paxAvailable = 0;
            } else {
                $newArry = [];
                for ($i = 0; $i < count($travelerPackage); $i++) {
                    array_push($newArry, $travelerPackage[$i]->checkout_package->qty);
                }
                $sum = array_sum($newArry);
                if ($checkData->quota > $sum) {
                    $paxAvailable = $checkData->quota - $sum;
                } else {
                    $paxAvailable = 0;
                }
            }


            $setData = [
                "id" => $checkData->id,
                "type" => $checkData->type,
                "duration" => $checkData->duration,
                "price" => $checkData->price,
                "quota" => $checkData->quota,
                "pax_available" => $paxAvailable,
                "review" => $totalShow,
                "rating" => 5,
                "destination" => [
                    "tag" => $checkData->destination->tag->name,
                    "country" => $checkData->destination->country->name,
                    "city" => $checkData->destination->city->name,
                    "province" => $checkData->destination->province->name,
                    "image" => base64_encode($imageContent),
                    "destination_name" => $checkData->destination->destination_name,
                    "description" => $checkData->destination->description,
                    "all_image" => Destination_detail::where('destination_id', $checkData->destination_id)->pluck('image'),
                ],
                "featured_trip" => FeaturedTrip::where("trip_package_id", $checkData->id)->pluck('name'),
                "acomodation" => Trip_AcomodationModel::where('trip_package_id', $checkData->id)->pluck('name'),
                "destination_trip" => Destination_detail::where('destination_id', $checkData->destination_id)->pluck('name')

            ];
            return $response->Response("success", $setData, 200);
        } else {
            return $response->Response("Data Not Found", null, 404);
        }
    }

    public function popularDestination()
    {
        $response = new Responses;
        try {
            $data = DB::table('checkout_instant_travel_sumaries')
                ->select('palace_id', DB::raw('COUNT(*) as total'))
                ->groupBy('palace_id')
                ->orderBy('total', 'desc')
                ->take(4)
                ->get();
            foreach ($data as $key => $value) {
                $popularData = Palace::where('id', $value->palace_id)->get();
                foreach ($popularData as $key => $valuetwo) {
                     $dataTransform[] = [
                    "id" => $valuetwo->id,
                    "destination" => $valuetwo->palace_name,
                    "image" => $valuetwo->image,
                    "tag" => $valuetwo->tag->name,
                    "country" => $valuetwo->country->name,
                    "province" => $valuetwo->province->name,
                    "city" => $valuetwo->city->name
                ];
                }
               
            }
            return $response->Response("success", $dataTransform, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 404);
        }
    }
    public function popularPackage()
    {
        $response = new Responses;
        try {
            $data = DB::table('checkout_package_travel_sumaries')
                ->select('trip_package_id', DB::raw('COUNT(*) as total'))
                ->groupBy('trip_package_id')
                ->orderBy('total', 'desc')
                ->take(4)
                ->get();
            foreach ($data as $key => $value) {
                $popularData = TripPackage::where('id', $value->trip_package_id)->get();
                foreach ($popularData as $key => $valuetwo) {
                     $dataTransform[] = [
                    "id" => $valuetwo->id,
                    "destination" => $valuetwo->destination->destination_name,
                    "image" => $valuetwo->destination->image,
                    "tag" => $valuetwo->destination->tag->name,
                    "country" => $valuetwo->destination->country->name,
                    "province" => $valuetwo->destination->province->name,
                    "city" => $valuetwo->destination->city->name
                ];
                }
               
            }
            return $response->Response("success", $dataTransform, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 404);
        }
    }

    public function ticketStore(Request $request)
    {
        $response = new Responses;
        try {
            $isValidateData = $request->validate([
                "first_name" => 'required|min:3|max:100',
                "last_name" => 'required|min:3|max:100',
                "email" => 'required|min:3|max:100',
                "phone" => 'required|min:3|max:100',
                "message" => 'required|min:3|max:100'
            ]);
            Ticket::create($isValidateData);
            return $response->Response("success", $isValidateData, 200);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }
}
