<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyOffering extends Model
{
    protected $table = 'key_offerings';

    protected $fillable = [
        'title',
        'description',
        'image',
        'category_id',
        'is_home'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }
}
