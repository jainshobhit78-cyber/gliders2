<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RTIOfficer extends Model
{

    protected $table = 'rti_officers';

    protected $fillable = [
        'title',
        'name',
        'post',
        'email',
        'phone',
        'role',
        'image'
    ];

}