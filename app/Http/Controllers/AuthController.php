<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Patient;

class AuthController extends Controller
{
    // PATIENT SELF-REGISTRATION
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone'    => 'required'
        ]);

        try {
            DB::transaction(function () use ($request) {

                $user = User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => bcrypt($request->password),
                    'role'     => 'patient'
                ]);

                Patient::create([
                    'user_id' => $user->id,
                    'phone'   => $request->phone
                ]);
            });

            return response()->json([
                'message' => 'Patient registered successfully'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // LOGIN (ALL ROLES)
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $user = $request->user();

        return response()->json([
            'token' => $user->createToken('api')->plainTextToken,
            'role'  => $user->role
        ]);
    }
}
