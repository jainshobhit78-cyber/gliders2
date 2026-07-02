<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlaylistImage extends Model
{
    protected $fillable = [
        'playlist_id',
        'image',
        'sub_heading',
        'caption'
    ];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}