<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Playlist;

class FMediaController extends Controller
{
    public function index($playlist = null)
    {
        $isElectionMode = \App\Models\GeneralSetting::isElectionMode();
        $playlistsQuery = Playlist::where('status', 'Published');

        if ($isElectionMode) {
            $playlistsQuery->where('hide_during_election', false);
        }

        $playlists = $playlistsQuery->latest()->get();

        if (!$playlist && $playlists->count()) {
            $playlist = $playlists->first()->id;
        }

        $selectedPlaylist = null;
        if ($playlist) {
            $selectedPlaylist = Playlist::with(['images', 'videos'])
                ->where('status', 'Published')
                ->when($isElectionMode, function($query) {
                    $query->where('hide_during_election', false);
                })
                ->find($playlist);
        }

        return view('frontend.media.index', compact(
            'playlists',
            'selectedPlaylist'
        ));
    }
}