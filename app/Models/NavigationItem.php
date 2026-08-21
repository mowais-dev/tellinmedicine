<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavigationItem extends Model
{
    protected $fillable = ['label', 'url', 'order', 'is_active', 'is_cta', 'care_model'];
    protected $casts = [
        'is_active' => 'boolean',
        'is_cta' => 'boolean',
        'order' => 'integer',
    ];
}
