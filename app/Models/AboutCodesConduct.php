<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutCodesConduct extends Model
{
    protected $table = 'about_codes_conduct';

    protected $fillable = [
        'title',
        'description',
        'pdf'
    ];
}