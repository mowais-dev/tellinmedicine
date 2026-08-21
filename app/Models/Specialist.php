<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    protected $fillable = [
        'name',
        'title',
        'qualifications',
        'image',
        'description',
        'experience_years',
        'order',
        'is_active',
    ];
}
