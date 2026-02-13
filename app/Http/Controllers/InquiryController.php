<?php

namespace App\Http\Controllers;



use App\Models\Inquires;
use Illuminate\Http\Request;


class inquiryController extends Controller
{

public function index(){
    $inquieres = Inquires::with('patient.user')
    ->latest()
    ->get();
    return response()->json($inquieres);


}



    public function store(Request $request){
        $request->validate([
        
            'subjec'=>'required|string|max:256',
            'message'=>'required|string'
        ]);

        Inquires::create([
            'Patient_id'=>$request->user()->patient->id,
            'subjec'=>$request->subject,
            'message'=>$request->message,
            'status'=>'new'

        ]);

        return response()->json(['message'=>'Inquiry sent successfully'],201);

    }

public function reply(Request $request, $id){
    $request -> validate([
        'status'=>'required|in:open,close'
    ]);

    $inquiry = Inquires::findorFail($id);

    $inquiry ->update([
        'status'=>$request->status
    ]);

    return response()->json(['message'=>'Inquiry updated successfully']);



}

}
