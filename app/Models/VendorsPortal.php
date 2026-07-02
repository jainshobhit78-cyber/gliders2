<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorsPortal extends Model
{

    protected $table = "vendors_portal";

    protected $fillable = [
        'title',
        'pdf'
    ];

}