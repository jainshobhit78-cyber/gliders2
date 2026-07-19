<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurPartner extends Model
{
    protected $table = 'our_partners';

    protected $fillable = [
        'image',
        'name',
    ];
}
