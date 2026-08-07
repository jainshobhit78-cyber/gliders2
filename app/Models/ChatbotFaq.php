<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatbotFaq extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'category',
        'is_starter',
        'position'
    ];

    protected $casts = [
        'is_starter' => 'boolean',
    ];
}
