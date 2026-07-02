<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VigilanceMonitor extends Model
{
    protected $table = 'vigilance_monitors';

    protected $fillable = [
        'title',
        'address'
    ];
}