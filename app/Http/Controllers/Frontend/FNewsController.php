<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Models\NewsCategory;

class FNewsController extends Controller
{
    // CATEGORY PAGE
    public function categories()
    {
        $isElectionMode = \App\Models\GeneralSetting::isElectionMode();
        $categories = NewsCategory::with([
            'articles' => function ($q) use ($isElectionMode) {
                $q->where('status', 'Published')
                    ->when($isElectionMode, function($query) {
                        $query->where('hide_during_election', false);
                    })
                    ->latest()
                    ->take(1);
            }
        ])->latest()->get();

        return view('frontend.news.categories', compact('categories'));
    }

    // ARTICLE LIST PAGE
    public function category($id)
    {
        $isElectionMode = \App\Models\GeneralSetting::isElectionMode();
        $categories = NewsCategory::latest()->get();

        $selectedCategory = NewsCategory::findOrFail($id);

        $articlesQuery = NewsArticle::where('category_id', $id)
            ->where('status', 'Published');

        if ($isElectionMode) {
            $articlesQuery->where('hide_during_election', false);
        }

        $articles = $articlesQuery->latest()->get();

        return view('frontend.news.index', compact(
            'categories',
            'articles',
            'selectedCategory'
        ));
    }

    // FULL ARTICLE PAGE
    public function show($id)
    {
        $isElectionMode = \App\Models\GeneralSetting::isElectionMode();
        $article = NewsArticle::with('category')->findOrFail($id);

        if ($article->status != 'Published' || ($isElectionMode && $article->hide_during_election)) {
            abort(404);
        }

        $relatedQuery = NewsArticle::where('category_id', $article->category_id)
            ->where('id', '!=', $id)
            ->where('status', 'Published');

        if ($isElectionMode) {
            $relatedQuery->where('hide_during_election', false);
        }

        $relatedArticles = $relatedQuery->latest()
            ->take(4)
            ->get();

        return view('frontend.news.show', compact(
            'article',
            'relatedArticles'
        ));
    }
}