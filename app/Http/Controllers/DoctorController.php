<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\appoitments;

class DoctorController extends Controller
{
    public function dashboard(Request $request)
{
    $doctor = $request->user()->doctor;

    if (!$doctor) {
        return response()->json([
            'message' => 'Doctor profile not found'
        ], 404);
    }

    $appointments = appoitments::with(['patient.user', 'schedule'])
        ->where('doctor_id', $doctor->id)
        ->get();

        return response()->json([
        'debug_doctor_id' => $doctor->id,
        'count' => $appointments->count(),
        'data' => $appointments
    ]);

    return response()->json([
        'doctor_id' => $doctor->id,
        'appointments' => $appointments
    ]);
}
}
