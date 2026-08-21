<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhilosophyContent extends Model
{
    protected $fillable = [
        'icon', 'title', 'highlight_quote', 'paragraph1', 'paragraph2',
        'cta_title', 'cta_text', 'cta_phone_text', 'cta_phone_url', 'cta_form_text', 'cta_form_url'
    ];
}
