<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutDirectory extends Model
{
    protected $table = 'about_directory';

    protected $casts = [
        'mobile_no' => 'array',
        'email' => 'array',
    ];
    protected $fillable = [
        'role',
        'sr_no',
        'org',
        'name',
        'designation',
        'sub_designation',
        'mobile_no',
        'telephone_number',
        'fax',
        'email',
        'deals_in',
        'profile_photo'
    ];
}