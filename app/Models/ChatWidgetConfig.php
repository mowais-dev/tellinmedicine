<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatWidgetConfig extends Model
{
    protected $fillable = ['assistant_name', 'status_text', 'welcome_message', 'input_placeholder'];
}
