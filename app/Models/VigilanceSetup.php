<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VigilanceSetup extends Model
{
    protected $table = 'vigilance_setup';

    protected $fillable = [
        'description',
        'image',
        'pdf'
    ];
}