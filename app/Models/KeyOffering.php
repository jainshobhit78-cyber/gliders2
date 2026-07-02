<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyOffering extends Model
{
    protected $table = 'key_offerings';

    protected $fillable = [
        'title',
        'description',
        'image',
        'is_home'
    ];
}
