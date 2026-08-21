<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingReason extends Model
{
    protected $fillable = ['label', 'value', 'redirect_url', 'order', 'is_active'];
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
