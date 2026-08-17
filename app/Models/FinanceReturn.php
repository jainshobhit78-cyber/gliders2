<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinanceReturn extends Model
{
    protected $table = 'finance_returns';

    protected $fillable = [
        'fiscal_year',
        'pdf',
        'display_order',
    ];
}
