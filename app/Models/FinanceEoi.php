<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceEoi extends Model
{
    protected $table = 'finance_eoi';

    protected $fillable = [
        'title',
        'description',
        'pdf'
    ];
}