<?php

namespace App\Http\Controllers;



use App\Models\Inquires;
use Illuminate\Http\Request;


class inquiryController extends Controller
{
    public function store(Request $request){
        $request->validate([
        
            'subjec'=>'required|string|max:256',
            'message'=>'required|string'
        ]);

        Inquires::create([
            'Patient_id'=>$request->user()->patient->id,
            'subjec'=>$request->subject,
            'message'=>$request->message

        ]);

        return response()->json(['message'=>'Inquiry sent'],201);

    }
}
