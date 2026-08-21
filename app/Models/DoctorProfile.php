<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $fillable = ['badge', 'name', 'credentials', 'quote', 'bio', 'photo_path'];
}
