<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Doctors;

class AdminUserController extends Controller
{
    // ADMIN CREATES DOCTOR
    public function createDoctor(Request $request)
    {
        $request->validate([
            'name'       => 'required|string',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'speciality' => 'required|string'
        ]);

        try {
            DB::transaction(function () use ($request) {

                $user = User::create([
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'password' => bcrypt($request->password),
                    'role'     => 'doctor'
                ]);

                Doctors::create([
                    'user_id'             => $user->id,
                    'speciality'          => $request->speciality,
                    'availability' => true
                ]);
            });

            return response()->json([
                'message' => 'Doctor created successfully'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Doctor creation failed',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
