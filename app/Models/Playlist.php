<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    protected $fillable = [
        'name',
        'heading',
        'description',
        'status',
        'hide_during_election'
    ];

    public function images()
    {
        return $this->hasMany(PlaylistImage::class, 'playlist_id');
    }

    public function videos()
    {
        return $this->hasMany(PlaylistVideo::class, 'playlist_id');
    }
}