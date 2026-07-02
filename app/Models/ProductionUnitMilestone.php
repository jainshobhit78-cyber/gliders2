<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionUnitMilestone extends Model
{
    protected $table = 'production_unit_milestones';

    protected $fillable = [
        'production_id',
        'milestone_date',
        'milestone_name',
        'bio',
        'video'
    ];

    public function images()
    {
        return $this->hasMany(ProductionUnitMilestoneImage::class, 'milestone_id')
            ->orderBy('sort_order');
    }
}