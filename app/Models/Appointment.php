<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_name',
        'patient_phone',
        'patient_email',
        'patient_age',
        'is_disabled',
        'appointment_date',
        'time_slot',
        'care_model',
        'reason',
        'status',
    ];
}
