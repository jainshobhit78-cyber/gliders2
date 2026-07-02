<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Models\Playlist;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        $user = auth()->guard('admin')->user();
        if (!$user->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $news = NewsArticle::where('status', 'Pending')->latest()->get();
        $playlists = Playlist::where('status', 'Pending')->latest()->get();

        return view('backend.approvals.list', compact('news', 'playlists'));
    }

    public function approveNews($id)
    {
        $user = auth()->guard('admin')->user();
        if (!$user->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $article = NewsArticle::findOrFail($id);
        $article->update(['status' => 'Published']);

        return back()->with('success', 'News article approved and published successfully.');
    }

    public function approveMedia($id)
    {
        $user = auth()->guard('admin')->user();
        if (!$user->hasRole('admin')) {
            abort(403, 'Unauthorized');
        }

        $playlist = Playlist::findOrFail($id);
        $playlist->update(['status' => 'Published']);

        return back()->with('success', 'Media playlist approved and published successfully.');
    }
}
