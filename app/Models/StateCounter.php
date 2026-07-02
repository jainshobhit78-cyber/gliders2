<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StateCounter extends Model
{
    protected $table = 'state_counter';

    protected $fillable = [
        'years_of_legacy',
        'parachutes_manufactured',
        'indigenous_manufacturing',
        'annual_production_value',
    ];
}
