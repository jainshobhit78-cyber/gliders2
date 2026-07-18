<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistVideo extends Model
{
    protected $fillable = [
        'playlist_id',
        'video',
        'caption',
        'likes'
    ];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}