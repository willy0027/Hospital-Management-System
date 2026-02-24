<?php

namespace App\Http\Controllers;

use App\Models\Appoitments;
use App\Models\Schedules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppoitmentController extends Controller
{
    /**
     * Book an appointment
     */
    public function book(Request $request)
    {
        // ✅ Validate request
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id'
        ]);

        // ✅ Get schedule
        $schedule = Schedules::findOrFail($request->schedule_id);

        // ✅ Check if already booked
        if ($schedule->is_booked) {
            return response()->json([
                'error' => 'This schedule slot is already booked'
            ], 400);
        }

        // ✅ Get logged in patient
        $patient = Auth::user()->patient;

        if (!$patient) {
            return response()->json([
                'error' => 'Patient profile not found'
            ], 404);
        }

        // ✅ Create appointment
        $appointment = appoitments::create([
            'patient_id'  => $patient->id,
            'doctor_id'   => $schedule->doctor_id,
            'schedule_id' => $schedule->id,
            'status'      => 'booked'
        ]);

        // ✅ Mark schedule as booked
        $schedule->update([
            'is_booked' => true
        ]);

        return response()->json([
            'message' => 'Appointment booked successfully',
            'appointment' => $appointment,
            'schedule' => [
                'available_date' => $schedule->available_date,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time
            ]
        ], 201);
    }

    /**
     * Cancel appointment
     */
    public function cancel($id)
    {
        $appointment = appoitments::findOrFail($id);

        // ✅ Update appointment status
        $appointment->update([
            'status' => 'cancelled'
        ]);

        // ✅ Free schedule slot again
        $appointment->schedule->update([
            'is_booked' => false
        ]);

        return response()->json([
            'message' => 'Appointment cancelled successfully'
        ]);
    }
}
