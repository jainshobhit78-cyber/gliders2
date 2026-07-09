<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\PlaylistImage;
use App\Models\PlaylistVideo;
use Illuminate\Http\Request;


class MediaController extends Controller
{

    public function list()
    {

        $playlists = Playlist::with(['images', 'videos'])->latest()->get();

        return view('backend.media.list', compact('playlists'));

    }

    public function add()
    {
        return view('backend.media.add');
    }

    public function uploadVideo(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimetypes:video/mp4,video/webm,video/ogg|max:51200',
        ]);

        if ($request->hasFile('file')) {
            $video = $request->file('file');
            $name = $video->hashName();
            $video->move(public_path('uploads/media/videos'), $name);
            return response()->json(['name' => $name]);
        }
        return response()->json(['error' => 'No file provided'], 400);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'heading' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:Pending,Published,Draft',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:5120',
            'videos.*' => 'nullable|file|mimetypes:video/mp4,video/webm,video/ogg|max:51200',
        ]);

        // Determine status based on role
        $status = 'Pending';
        if (auth()->guard('admin')->user()->hasRole('admin')) {
            $status = $request->status ?? 'Published';
        }

        $playlist = Playlist::create([
            'name' => $request->name,
            'heading' => $request->heading,
            'description' => $request->description,
            'status' => $status,
            'hide_during_election' => $request->has('hide_during_election')
        ]);

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $key => $img) {

                $name = $img->hashName();
                $img->move(public_path('uploads/media/images'), $name);

                PlaylistImage::create([
                    'playlist_id' => $playlist->id,
                    'image' => $name,
                    'sub_heading' => $request->image_sub_heading[$key] ?? null,
                    'caption' => $request->image_caption[$key] ?? null
                ]);
            }
        }

        if ($request->hasFile('videos')) {

            foreach ($request->file('videos') as $key => $video) {

                $name = $video->hashName();
                $video->move(public_path('uploads/media/videos'), $name);

                PlaylistVideo::create([
                    'playlist_id' => $playlist->id,
                    'video' => $name,
                    'caption' => $request->video_caption[$key] ?? null
                ]);
            }
        }

        return redirect('admin/media')->with('success', 'Playlist Created');

    }

    public function edit($id)
    {

        $playlist = Playlist::with(['images', 'videos'])->find($id);

        return view('backend.media.edit', compact('playlist'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'heading' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:Pending,Published,Draft',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:5120',
            'videos.*' => 'nullable|file|mimetypes:video/mp4,video/webm,video/ogg|max:51200',
        ]);

        $playlist = Playlist::find($id);

        // Determine status based on role
        $status = $playlist->status;
        if (auth()->guard('admin')->user()->hasRole('admin')) {
            $status = $request->status ?? $playlist->status;
        }

        $playlist->update([
            'name' => $request->name,
            'heading' => $request->heading,
            'description' => $request->description,
            'status' => $status,
            'hide_during_election' => $request->has('hide_during_election')
        ]);

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $key => $img) {

                $name = $img->hashName();
                $img->move(public_path('uploads/media/images'), $name);

                PlaylistImage::create([
                    'playlist_id' => $playlist->id,
                    'image' => $name,
                    'sub_heading' => $request->image_sub_heading[$key] ?? null,
                    'caption' => $request->image_caption[$key] ?? null
                ]);
            }
        }

        if ($request->hasFile('videos')) {

            foreach ($request->file('videos') as $key => $video) {

                $name = $video->hashName();
                $video->move(public_path('uploads/media/videos'), $name);

                PlaylistVideo::create([
                    'playlist_id' => $playlist->id,
                    'video' => $name,
                    'caption' => $request->video_caption[$key] ?? null
                ]);
            }
        }

        if ($request->video_caption_existing) {
            foreach ($request->video_caption_existing as $index => $caption) {
                if (isset($playlist->videos[$index])) {
                    $playlist->videos[$index]->update([
                        'caption' => $caption
                    ]);
                }
            }
        }
        // UPDATE EXISTING IMAGES
        if ($request->existing_image_caption) {
            foreach ($request->existing_image_caption as $index => $caption) {

                if (isset($playlist->images[$index])) {

                    $playlist->images[$index]->update([
                        'caption' => $caption,
                        'sub_heading' => $request->existing_image_sub_heading[$index] ?? null
                    ]);

                }
            }
        }
        if ($request->remove_videos) {
            $ids = explode(',', $request->remove_videos);
            foreach ($ids as $id) {
                $video = PlaylistVideo::find($id);
                if ($video) {
                    $path = public_path('uploads/media/videos/' . $video->video);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    $video->delete();
                }
            }
        }

        if ($request->remove_images) {
            $ids = explode(',', $request->remove_images);
            foreach ($ids as $id) {
                $img = PlaylistImage::find($id);
                if ($img) {
                    $path = public_path('uploads/media/images/' . $img->image);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                    $img->delete();
                }
            }
        }

        return redirect('admin/media')->with('success', 'Playlist Updated');
    }

    public function delete($id)
    {
        $playlist = Playlist::with(['images', 'videos'])->find($id);

        if ($playlist) {
            foreach ($playlist->images as $img) {
                $path = public_path('uploads/media/images/' . $img->image);
                if (file_exists($path)) {
                    unlink($path);
                }
                $img->delete();
            }

            foreach ($playlist->videos as $vid) {
                $path = public_path('uploads/media/videos/' . $vid->video);
                if (file_exists($path)) {
                    unlink($path);
                }
                $vid->delete();
            }

            $playlist->delete();
        }

        return redirect('admin/media')->with('success', 'Deleted successfully');
    }

}

