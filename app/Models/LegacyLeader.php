<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegacyLeader extends Model
{
    protected $table = 'legacy_leaders';

    protected $fillable = [
        'name',
        'role',
        'type',
        'tenure_start',
        'tenure_end',
        'tenure_text',
        'initials',
        'color',
        'image',
        'description',
        'quote',
        'achievements',
        'focus_areas',
        'stats',
        'timeline',
        'display_order'
    ];

    protected $casts = [
        'focus_areas' => 'array',
        'stats' => 'array',
        'timeline' => 'array',
    ];
}
