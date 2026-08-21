<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreventiveChecklist extends Model
{
    protected $fillable = ['title', 'border_color', 'items', 'order', 'is_active'];
    protected $casts = [
        'items' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
