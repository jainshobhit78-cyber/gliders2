<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RajshabhaAbout extends Model
{

    protected $table = "rajshabha_about";

    protected $fillable = [
        'heading',
        'description',
        'pdf'
    ];

}