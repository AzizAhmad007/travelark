<?php

namespace App\Http\Controllers;

use App\Models\Destination_detail;
use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Exception;

class Destination_detailController extends Controller
{
    public function index()
    {
        $destination_detail = Destination_detail::all();
        return $destination_detail;
    }

    public function show($id)
    {
        try {
            $destination_detail = Destination_detail::find($id);
            if ($destination_detail == null) {
                throw new Exception('Data tidak ditemukan');
            }
            return $destination_detail;

            return response()->json([
                'message' => 'Data ditemukan',
                'statusCode' => 200,
                'data' => $destination_detail
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
