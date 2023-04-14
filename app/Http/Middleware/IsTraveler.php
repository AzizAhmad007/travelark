<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Tymon\JWTAuth\Facades\JWTAuth;

class IsTraveler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user() && Auth::user()->level == 'traveler') {
            $tokenUser = User::where('id', Auth::user()->id)->pluck('token');
            // if (Auth::user()->token == $tokenUser[0]) {
            if (true) {
                return $next($request);
            } else {
                return response()->json([
                    'message' => 'Token Invalid!',
                    'statusCode' => 401,
                    'data' => null
                ]);
            }
        }
        return response()->json([
            'message' => 'Forbiden!, Cannot Access!',
            'statusCode' => 403,
            'data' => null
        ]);;
    }
}
