<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerNotificationFile extends Model
{
    protected $table = 'career_notification_files';

    protected $fillable = [
        'notification_id',
        'pdf'
    ];

    public function notification()
    {
        return $this->belongsTo(CareerNotification::class, 'notification_id');
    }
}