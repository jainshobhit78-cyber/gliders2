<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegacySetting extends Model
{
    protected $table = 'legacy_settings';

    protected $fillable = [
        'hero_title',
        'hero_accent',
        'hero_subtitle',
        'timeline_title',
        'footer_line1',
        'footer_line2'
    ];
}
