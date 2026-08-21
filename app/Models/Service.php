<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'category', 'icon', 'title', 'description',
        'features', 'button_text', 'button_url', 'care_model', 'order', 'is_active'
    ];
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
