<?php

namespace App\Http\Controllers;

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
        $validator = Validator::make(request()->all(), [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'fullname' => 'required|min:5|max:40',
            'password' => 'required|min:3|max:30',
            'phone' => 'required|max:13',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Error Gagal Register']);
        }

        $user = User::create([
            'username' => request('username'),
            'email' => request('email'),
            'fullname' => request('fullname'),
            'password' => Hash::make(request('password')),
            'phone' => request('phone'),
            'level' => "traveler",
        ]);

        if ($user) {
            return response()->json([
                'message' => 'user created',
                'statusCode' => 200,
                "data" => request()->all()
            ]);
        } else {
            return response()->json([
                'message' => 'faileduser created',
                'statusCode' => 400,
                "data" => null
            ]);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['username', 'password']);
        try {
            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $record = User::where('username', $credentials["username"])->first();
            $record->token = $token;
            $record->save();
            $tokenAfterEncrypt = Crypt::encryptString($token);
            return $this->respondWithToken($tokenAfterEncrypt);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage(),
                'statusCode' => 400,
                "data" => null
            ]);
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
            "username" => auth()->user()->username,
            "email" => auth()->user()->email,
            "fullname" => auth()->user()->fullname,
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
