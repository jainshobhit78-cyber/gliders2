<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSocialResponsibility extends Model
{
    protected $table = 'about_social_responsibility';

    protected $fillable = [
        'name',
        'title',
        'sub_title',
        'phone',
        'photo'
    ];
}