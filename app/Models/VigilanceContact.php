<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VigilanceContact extends Model
{

    protected $table = 'vigilance_contacts';

    protected $fillable = [
        'title',
        'sub_title',
        'name',
        'emails',
        'photo',
        'address'
    ];

    protected $casts = [
        'emails' => 'array'
    ];

}