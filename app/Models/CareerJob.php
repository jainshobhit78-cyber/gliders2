<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerJob extends Model
{
    protected $table = 'career_jobs';

    protected $fillable = [
        'type',
        'title',
        'job_info',
        'eligibility',
        'last_date',
        'pdf',
        'status'
    ];

    protected $casts = [
        'last_date' => 'date',
        'status' => 'boolean'
    ];
}
