<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class Appoitments extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'schedule_id',
        'status'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctors::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedules::class);
    }
}
