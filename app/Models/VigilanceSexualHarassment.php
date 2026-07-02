<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VigilanceSexualHarassment extends Model
{

    protected $table = 'vigilance_sexual_harassment';

    protected $fillable = [
        'info_text',
        'image',
        'pdf'
    ];

}