<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutVision extends Model
{
    protected $table = 'about_vision';

    protected $fillable = [
        'title',
        'description'
    ];
}