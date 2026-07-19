<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    protected $table = 'social_posts';

    protected $fillable = [
        'platform',   // facebook | linkedin | instagram
        'author',
        'post_date',
        'content',
        'image',
        'likes',
        'comments',
        'shares',
        'link',
        'status',     // Published | Draft
        'sort_order',
    ];
}
