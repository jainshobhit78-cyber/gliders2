<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VigilanceCvo extends Model
{
    protected $table = 'vigilance_cvo';

    protected $fillable = [
        'name',
        'title',
        'sub_title',
        'description',
        'image',
        'pdf'
    ];
}