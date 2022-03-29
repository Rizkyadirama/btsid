<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use JWTAuth;
use Illuminate\Support\Facades\Hash;

class JWTController extends Controller
{
    protected $user;
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','allUser']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [            
            'email' => 'required|string|email|max:100|unique:user',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
                'username'=> $request->username,
                'email' => $request->email,                
                'password' => Hash::make($request->password),
                'phone' => $request->phone,  
                'address' => $request->address,                              
                'city' => $request->city,                
                'country' => $request->country,                
                'name' => $request->name,    
                'postcode' => $request->postcode,                            
            ]);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function allUser(){
        $this->user = JWTAuth::parseToken()->authenticate();
        return User::all();
    }
}
