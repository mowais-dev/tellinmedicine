<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $fillable = [
        'page', 'badge', 'title', 'title_highlight', 'subtitle', 'image_path', 'image_rotation',
        'primary_button_text', 'primary_button_url', 'primary_button_model',
        'secondary_button_text', 'secondary_button_url', 'secondary_button_model',
        'badge1_title', 'badge1_sub', 'badge2_title', 'badge2_sub'
    ];

    protected $casts = [
        'image_rotation' => 'integer',
    ];
}
