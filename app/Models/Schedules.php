<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedules extends Model
{
       protected $table = 'schedules';

    protected $fillable = [
        'doctor_id',
        'available_date',
        'start_time',
        'end_time',
        'is_booked'
    ];

    
    public function doctor()
    {
        return $this->belongsTo(Doctors::class);
    }
    
}
