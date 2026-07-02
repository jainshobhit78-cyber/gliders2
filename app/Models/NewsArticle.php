<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    protected $table = 'news_articles';

    protected $fillable = [
        'category_id',
        'title',
        'subtitle',
        'author',
        'wallpaper',
        'content',
        'publish_date',
        'status',
        'hide_during_election'
    ];

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'category_id');
    }
}