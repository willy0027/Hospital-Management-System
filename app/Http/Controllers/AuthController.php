<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'       => 'required|string',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'role'       => 'required|in:doctor,patient',
            'phone'      => 'required_if:role,patient',
            'speciality' => 'required_if:role,doctor',
            'availability' => 'nullable|boolean'
        ]);

        try {
            DB::transaction(function () use ($request) {

                $user = User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => bcrypt($request->password),
                    'role'     => $request->role
                ]);

                if ($request->role === 'doctor') {
                    Doctor::create([
                        'user_id' => $user->id,
                        'speciality' => $request->speciality,
                        'availability_status' => $request->availability ?? true
                    ]);
                }

                if ($request->role === 'patient') {
                    Patient::create([
                        'user_id' => $user->id,
                        'phone'   => $request->phone
                    ]);
                }
            });

            return response()->json([
                'message' => 'User registered successfully'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User registration failed',
                'error'   => $e->getMessage()
            ], 500);
        }
    }



    public function login(Request $request){
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['error'=>'invalid credential'],401);
        }

        $token = $request->user()->createToken('api')->PlainTextToken;

        return response()->json(['token'=>$token,'role'=>$request->user()->role]);
    }
}



