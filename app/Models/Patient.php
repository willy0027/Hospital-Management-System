<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone'
    ];


    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
    
}


public function appointments()
{
    return $this->hasMany(Appoitments::class);
}


}
