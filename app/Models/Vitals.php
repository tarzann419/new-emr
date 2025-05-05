<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vitals extends Model
{
    protected $guarded = [];

    // Define relationships with other models
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
