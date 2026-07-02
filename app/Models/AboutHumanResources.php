<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutHumanResources extends Model
{
    protected $table = 'about_human_resources';

    protected $fillable = [
        'title',
        'description',
        'vision',
        'mission',
        'objectives',
        'strategy'
    ];
}