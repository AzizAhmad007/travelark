<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Responses\Responses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register()
    {
        $response = new Responses;
        $validator = Validator::make(request()->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3|max:30',
            'phone' => 'required|max:13',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error Gagal Register']);
        }

        $user = User::create([
            'username' => request('username'),
            'email' => request('email'),
            'password' => Hash::make(request('password')),
            'phone' => request('phone'),
            'level' => "traveler",
        ]);

        if ($user) {
            return $response->Response("user created", request()->all(), 200);
        } else {
            return $response->Response("faild user created", null, 400);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $response = new Responses;
        $credentials = request(['username', 'password']);
        try {
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $record = User::where('username', $credentials["username"])->first();
            $record->token = $token;
            $record->save();
            // $tokenAfterEncrypt = Crypt::encryptString($token);
            return $this->respondWithToken($token);
        } catch (\Throwable $th) {
            return $response->Response($th->getMessage(), null, 400);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out',  'statusCode' => 200]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $dataUser = [
            "id" => auth()->user()->id,
            "username" => auth()->user()->username,
            "email" => auth()->user()->email,
            "phone" => auth()->user()->phone,
            "level" => auth()->user()->level
        ];
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'data' => $dataUser
        ]);
    }
}
