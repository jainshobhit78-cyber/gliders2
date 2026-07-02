<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutMission extends Model
{
    protected $table = 'about_mission';

    protected $fillable = [
        'title',
        'description'
    ];
}