<?php

namespace App\Http\Controllers;

use App\Models\Appoitments;
use App\Models\Schedules;
use Illuminate\Http\Request;

class AppoitmentController extends Controller
{
    public function book(Request $request)
    {
        $schedule = Schedules::findOrFail($request->schedule_id);

        if ($schedule->is_booked) {
            return response()->json([
                'error' => 'Slot is already taken'
            ], 400);
        }

        Appoitments::create([
            'patient_id'  => $request->user()->patient->id,
            'doctor_id'   => $schedule->doctor_id,
            'schedule_id' => $schedule->id,
            'status'      => 'booked'
        ]);

        $schedule->update([
            'is_booked' => true
        ]);

        return response()->json([
            'message' => 'Appoitment booked successfully'
        ]);
    }

    public function cancel($id)
    {
        $appoitment = Appoitments::findOrFail($id);

        $appoitment->update([
            'status' => 'cancelled'
        ]);

        return response()->json([
            'message' => 'Appoitment Cancelled'
        ]);
    }
}
