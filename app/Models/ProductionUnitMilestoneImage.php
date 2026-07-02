<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionUnitMilestoneImage extends Model
{
    protected $table = 'production_unit_milestone_images';

    protected $fillable = [
        'milestone_id',
        'image',
        'sort_order'
    ];
}