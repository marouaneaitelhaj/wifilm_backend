<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function register(Request $request)
    {
        $validation = $request->validate([
            "name" => "required|min:3|max:255",
            "email" => "required|email|unique:users,email",
            "password" => "required|min:8|max:255"
        ]);
        $user = User::create([
            "name" => $validation["name"],
            "email" => $validation["email"],
            "password" => bcrypt($validation["password"])
        ]);
        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }
    public function login(Request $request)
    {
        $validation = $request->validate([
            "email" => "required|email",
            "password" => "required|min:8|max:255"
        ]);
        $token = Auth::attempt($validation);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid login details',
            ], 401);
        }
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'message' => 'User logged in successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }
}
