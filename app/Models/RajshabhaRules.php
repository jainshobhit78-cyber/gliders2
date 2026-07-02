<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RajshabhaRules extends Model
{

    protected $table = "rajshabha_rules";

    protected $fillable = [
        'heading',
        'pdf'
    ];

}