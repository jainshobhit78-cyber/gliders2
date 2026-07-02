<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TickerNews extends Model
{
    protected $table = 'ticker_news';

    protected $fillable = [
        'text',
        'link',
        'is_active',
        'position',
    ];
}
