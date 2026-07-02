<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RTIInformation extends Model
{
    protected $table = 'rti_information';

    protected $fillable = [
        'info_text',
        'pdf'
    ];
}