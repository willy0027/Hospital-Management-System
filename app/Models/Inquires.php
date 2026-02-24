<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquires extends Model
{
        protected $fillable = [
            'patient_id',
            'subject',
            'message',
            'status'

    ];

    public function patient()
{
    return $this->belongsTo(Patient::class);
}
}
