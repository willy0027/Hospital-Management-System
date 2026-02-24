<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctors extends Model
{
      protected $fillable = ['user_id','speciality','availability'];


          public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedules::class, 'doctor_id');
    }

    public function appointments()
{
    return $this->hasMany(Appoitments::class, 'doctor_id');
}
}
