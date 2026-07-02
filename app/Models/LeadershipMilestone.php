<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadershipMilestone extends Model
{
    protected $fillable = [
        'leadership_id',
        'start_date',
        'end_date',
        'heading',
        'description',
        'image'
    ];
}