<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NewsCategory;
use App\Models\NewsArticle;

class NewsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | News Dashboard Page
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $categories = NewsCategory::latest()->get();

        return view('backend.news.index', compact('categories'));
    }


    /*
    |--------------------------------------------------------------------------
    | News List (Ajax Load)
    |--------------------------------------------------------------------------
    */

    public function list(Request $request)
    {

        $categories = NewsCategory::latest()->get();

        $query = NewsArticle::with('category');

        // Category Filter
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        // Search Filter
        if ($request->search) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $items = $query->latest()->get();

        return view('backend.news.list', compact('items', 'categories'));
    }


    /*
    |--------------------------------------------------------------------------
    | Open Add News Page
    |--------------------------------------------------------------------------
    */

    public function add()
    {
        $categories = NewsCategory::latest()->get();

        return view('backend.news.add', compact('categories'));
    }


    /*
    |--------------------------------------------------------------------------
    | Store News Article
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'wallpaper' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $image = null;

        if ($request->hasFile('wallpaper')) {

            $image = time() . '_' . rand(111, 999) . '.' . $request->wallpaper->extension();

            $request->wallpaper->move(public_path('uploads/news'), $image);
        }

        // Determine status based on role or permissions
        $status = 'Pending';
        if (auth()->guard('admin')->user()->hasRole('admin') || auth()->guard('admin')->user()->can('news.edit') || auth()->guard('admin')->user()->can('news.create')) {
            $status = $request->status ?? 'Published';
        }

        NewsArticle::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'author' => $request->author,
            'wallpaper' => $image,
            'content' => $request->input('content'),
            'publish_date' => $request->publish_date,
            'status' => $status,
            'hide_during_election' => $request->has('hide_during_election')
        ]);

        if (auth()->guard('admin')->user()->can('news.view')) {
            return redirect('admin/news')->with('success', 'News Article created successfully.');
        }
        return redirect('admin/dashboard')->with('success', 'News Article created successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Edit News Page
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {

        $item = NewsArticle::findOrFail($id);

        $categories = NewsCategory::latest()->get();

        return view('backend.news.edit', compact('item', 'categories'));
    }


    /*
    |--------------------------------------------------------------------------
    | Update News Article
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'wallpaper' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $item = NewsArticle::findOrFail($id);

        $image = $item->wallpaper;

        if ($request->hasFile('wallpaper')) {

            // Delete old image
            if ($item->wallpaper && file_exists(public_path('uploads/news/' . $item->wallpaper))) {
                unlink(public_path('uploads/news/' . $item->wallpaper));
            }

            $image = time() . '_' . rand(111, 999) . '.' . $request->wallpaper->extension();

            $request->wallpaper->move(public_path('uploads/news'), $image);
        }

        // Determine status based on role or edit permissions
        $status = $item->status;
        if (auth()->guard('admin')->user()->hasRole('admin') || auth()->guard('admin')->user()->can('news.edit')) {
            $status = $request->status ?? $item->status;
        }

        $item->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'author' => $request->author,
            'wallpaper' => $image,
            'content' => $request->input('content'),
            'publish_date' => $request->publish_date,
            'status' => $status,
            'hide_during_election' => $request->has('hide_during_election')
        ]);

        if (auth()->guard('admin')->user()->can('news.view')) {
            return redirect('admin/news')->with('success', 'News Article updated successfully.');
        }
        return redirect('admin/dashboard')->with('success', 'News Article updated successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Delete News
    |--------------------------------------------------------------------------
    */

    public function delete($id)
    {

        $item = NewsArticle::findOrFail($id);

        if ($item->wallpaper && file_exists(public_path('uploads/news/' . $item->wallpaper))) {
            unlink(public_path('uploads/news/' . $item->wallpaper));
        }

        $item->delete();

        return back();
    }


    /*
    |--------------------------------------------------------------------------
    | Add News Category
    |--------------------------------------------------------------------------
    */

    public function categoryAdd(Request $request)
    {

        $request->validate([
            'name' => 'required'
        ]);

        NewsCategory::create([
            'name' => $request->name
        ]);

        return back();
    }


    /*
    |--------------------------------------------------------------------------
    | Update News Category
    |--------------------------------------------------------------------------
    */

    public function categoryUpdate(Request $request, $id)
    {

        $request->validate([
            'name' => 'required'
        ]);

        $category = NewsCategory::findOrFail($id);

        $category->update([
            'name' => $request->name
        ]);

        return back();
    }
}
