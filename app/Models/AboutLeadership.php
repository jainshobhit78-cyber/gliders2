<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutLeadership extends Model
{
    protected $table = 'about_leadership';

    protected $fillable = [
        'leader_name',
        'role',
        'sub_title',
        'bio',
        'milestone1',
        'milestone2',
        'position',
        'picture'
    ];

    public function milestones()
    {
        return $this->hasMany(LeadershipMilestone::class, 'leadership_id');
    }
}