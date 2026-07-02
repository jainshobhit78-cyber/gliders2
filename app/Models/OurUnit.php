<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurUnit extends Model
{
    protected $table = 'our_units';

    protected $fillable = [
        'heading',
        'sub_heading',
        'description',
        'video',
    ];
}
