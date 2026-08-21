<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pillar extends Model
{
    protected $fillable = [
        'page', 'icon', 'image_path', 'title', 'description',
        'link_text', 'link_url', 'care_model', 'order', 'is_active'
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
