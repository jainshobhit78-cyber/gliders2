<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    protected $table = 'news_categories';

    protected $fillable = ['name'];

    public function articles()
    {
        return $this->hasMany(NewsArticle::class, 'category_id');
    }
}