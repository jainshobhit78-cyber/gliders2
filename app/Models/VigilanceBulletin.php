<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VigilanceBulletin extends Model
{
    protected $table = 'vigilance_bulletins';

    protected $fillable = [
        'info_text',
        'pdf'
    ];
}