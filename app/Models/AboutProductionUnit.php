<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutProductionUnit extends Model
{
    protected $table = 'about_production_units';

    protected $fillable = [
        'profile',
        'heading',
        'sub_heading',
        'bio',
        'milestone',
        'image',
        'video'
    ];
    public function images()
    {
        return $this->hasMany(AboutProductionUnitImage::class, 'production_id')
            ->orderBy('sort_order', 'asc');
    }

    public function milestones()
    {
        return $this->hasMany(ProductionUnitMilestone::class, 'production_id');
    }
}