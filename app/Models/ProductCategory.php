<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'image',
        'status',
        'display_order'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
