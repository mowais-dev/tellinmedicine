<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducationGuide extends Model
{
    protected $fillable = ['icon', 'icon_bg', 'title', 'description', 'features', 'order', 'is_active'];
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
