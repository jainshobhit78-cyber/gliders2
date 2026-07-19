<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerLogo extends Model
{
    protected $table = 'partner_logo';

    protected $fillable = [
        'image',
        'name',
    ];
}
