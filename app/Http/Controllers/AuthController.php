<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = app('auth')->login($user);

            return response()->json([
                'message' => 'Successfully Registered New User',
                'data' => $user,
                'token' => $token,
                'expires' => app('auth')->factory()->getTTL() * 60,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);
        try {
            $user = $request->only(['email', 'password']);

            if (!$token = app('auth')->attempt($user)) {
                return response()->json([
                    'message' => 'Login Failed, Wrong Email or Password',
                ], 400);
            }
            return response()->json([
                'message' => 'Successfully logged in',
                'token' => $token,
                'expires' => app('auth')->factory()->getTTL() * 60,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    public function logout()
    {
        try {
            app('auth')->logout();  
            return response()->json([
                'message' => 'Successfully logged out'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }

    public function getUser()
    {
        try {
            return response()->json([
                'message' => 'Authenticated User',
                'data' => app('auth')->user(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Internal server error',
            ], 500);
        }
    }
}
