<?php
namespace App\Http\Controllers\Responses;
class Responses
{
    public function Response($message, $data, $code)
    {
        
        return response()->json([
            "message" => $message,
            'statusCode' => $code,
            "data" => $data
        ]);
    }
    public function ResponseWithPagination($message, $data, $code, $totalItem)
    {
        
        return response()->json([
            "message" => $message,
            'statusCode' => $code,
            'totalItem' => $totalItem,
            "data" => $data
        ]);
    }
}