<?php

namespace App\Http\Controllers;

use App\Models\CitiModel;
use Illuminate\Http\Request;

class CitiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            "message" => "success",
            'statusCode' => 200,
            "data" => CitiModel::all(),
        ]);
    }
}

//     /**
//      * Store a newly created resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @return \Illuminate\Http\Response
//      */
//     public function store(Request $request)
//     {
//         try {
//             $isValidateData = $request->validate([
//                 "name" => 'required',
//             ]);
//             CitiModel::create($isValidateData);
//             return response()->json([
//                 "message" => "success",
//                 'statusCode' => 200,
//                 "data" => $isValidateData,
//             ]);
//         } catch (\Throwable $th) {
//             return response()->json([
//                 "message" => $th->getMessage(),
//                 'statusCode' => 400,
//                 "data" => null
//             ]);
//         }
//     }

//     /**
//      * Display the specified resource.
//      *
//      * @param  \App\Models\CitiModel  $citiModel
//      * @return \Illuminate\Http\Response
//      */
//     public function show(CitiModel $citiModel)
//     {
//         try {
//             return response()->json([
//                 "message" => "success",
//                 'statusCode' => 200,
//                 "data" => CitiModel::find($citiModel)
//             ]);;
//         } catch (\Throwable $th) {
//             return response()->json([
//                 "message" => 'error data tidak di temukan',
//                 'statusCode' => 404,
//                 "data" => null
//             ]);
//         }
//     }

//     /**
//      * Update the specified resource in storage.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \App\Models\CitiModel  $citiModel
//      * @return \Illuminate\Http\Response
//      */
//     public function update(Request $request, CitiModel $citiModel)
//     {
//         try {
//             $isValidateData = $request->validate([
//                 "name" => 'required',
//             ]);
//             $citiModel->update($isValidateData);
//             return response()->json([
//                 "message" => "success",
//                 'statusCode' => 200,
//                 "data" => $isValidateData,
//             ]);
//         } catch (\Throwable $th) {
//             return response()->json([
//                 "message" => $th->getMessage(),
//                 'statusCode' => 400,
//                 "data" => null
//             ]);
//         }
//     }

//     /**
//      * Remove the specified resource from storage.
//      *
//      * @param  \App\Models\CitiModel  $citiModel
//      * @return \Illuminate\Http\Response
//      */
//     public function destroy(CitiModel $citiModel)
//     {
//         try {
//             $citiModel->delete();
//             return response()->json([
//                 "message" => "success",
//                 'statusCode' => 200,
//             ]);
//         } catch (\Throwable $th) {
//             return response()->json([
//                 "message" => $th->getMessage(),
//                 'statusCode' => 400,
//             ]);
//         }
//     }
//     public function storJwt(CitiModel $citiModel)
//     {
//         try {
//             $citiModel->delete();
//             return response()->json([
//                 "message" => "success",
//                 'statusCode' => 200,
//             ]);
//         } catch (\Throwable $th) {
//             return response()->json([
//                 "message" => $th->getMessage(),
//                 'statusCode' => 400,
//             ]);
//         }
//     }
// }
