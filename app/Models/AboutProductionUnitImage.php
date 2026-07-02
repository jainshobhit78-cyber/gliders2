<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutProductionUnitImage extends Model
{
    protected $table = "about_production_unit_images";

    protected $fillable = [
        'production_id',
        'image',
        'sort_order'   // ⚡ ADD THIS
    ];
}
