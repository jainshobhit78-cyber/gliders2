<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VigilanceManual extends Model
{
    protected $table = 'vigilance_manuals';

    protected $fillable = [
        'info_text',
        'pdf'
    ];
}