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

    /**
     * Repair known mojibake (UTF-8 read as Windows-1252) on read so corrupted
     * content still displays correctly even before the underlying row is cleaned.
     * Currently targets the Indian Rupee sign in both its raw double-encoded byte
     * form and its HTML-entity form. Idempotent and safe to run repeatedly.
     */
    protected function fixEncoding($value)
    {
        if (! is_string($value) || $value === '') {
            return $value;
        }

        $rupee = "\xE2\x82\xB9"; // ₹ (U+20B9)

        return strtr($value, [
            '&acirc;&sbquo;&sup1;'         => $rupee, // entity form
            "\xC3\xA2\xE2\x80\x9A\xC2\xB9" => $rupee, // double-encoded UTF-8 bytes (â‚¹)
        ]);
    }

    public function getTitleAttribute($value)
    {
        return $this->fixEncoding($value);
    }

    public function getSubtitleAttribute($value)
    {
        return $this->fixEncoding($value);
    }

    public function getContentAttribute($value)
    {
        return $this->fixEncoding($value);
    }
}