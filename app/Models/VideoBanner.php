<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoBanner extends Model
{
    protected $table = 'video_banner';

    protected $fillable = [
        'title',
        'banner_video',
        'mid_video'
    ];
}
