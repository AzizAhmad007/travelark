<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Tymon\JWTAuth\Facades\JWTAuth;

class IsAdmin
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
        if (Auth::user() && Auth::user()->level == 'admin') {
            try {
                $token = Crypt::decryptString($request->input('token_enc'));
                JWTAuth::toUser($token);
            } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
                // Token is invalid
                return response()->json([
                    'message' => $e->getMessage(),
                    'statusCode' => 401,
                    'data' => null
                ]);
            }
            return $next($request);
        }
        return response()->json([
            'message' => 'Forbiden, Cannot Access!',
            'statusCode' => 403,
            'data' => null
        ]);;
    }
}
