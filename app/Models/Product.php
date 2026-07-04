<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'description',
        'wallpaper',
        'delivery_tag',
        'specs_subtext',
        'specs_image',
        'technical_specs',
        'caps_image',
        'main_capabilities'
    ];

    protected $casts = [
        'technical_specs' => 'array',
        'main_capabilities' => 'array'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}