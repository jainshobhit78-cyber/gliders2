<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerNotification extends Model
{
    protected $table = 'career_notifications';

    protected $fillable = [
        'title',
        'description'
    ];

    public function files()
    {
        return $this->hasMany(CareerNotificationFile::class, 'notification_id');
    }
}