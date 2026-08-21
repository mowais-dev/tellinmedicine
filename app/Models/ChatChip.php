<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatChip extends Model
{
    protected $fillable = ['label', 'prompt', 'order', 'is_active'];
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
