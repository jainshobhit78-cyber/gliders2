<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles;

    protected $guard_name = 'admin'; 
    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo'
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    protected $hidden = [
        'password',
    ];
}
