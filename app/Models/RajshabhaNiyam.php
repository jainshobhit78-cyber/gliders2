<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RajshabhaNiyam extends Model
{

    protected $table = "rajshabha_niyam";

    protected $fillable = [
        'heading',
        'pdf'
    ];

}