<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorTimeline extends Model
{
    protected $fillable = ['year_range', 'title', 'description', 'order'];
    protected $casts = [
        'order' => 'integer',
    ];
}
