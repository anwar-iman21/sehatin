<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;

class ArticleController extends Controller
{
    public function index()
    {
        $articles   = Article::published()->with(['category', 'user'])->latest('published_at')->paginate(9);
        $categories = Category::withCount('publishedArticles')->orderBy('order')->get();

        return view('artikel.index', compact('articles', 'categories'));
    }

    public function show(Article $article)
    {
        if ($article->status !== 'published') {
            abort(404);
        }

        $related = Article::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('artikel.show', compact('article', 'related'));
    }

    public function byCategory(Category $category)
    {
        $articles = Article::published()
            ->where('category_id', $category->id)
            ->with(['user'])
            ->latest('published_at')
            ->paginate(9);

        $categories = Category::withCount('publishedArticles')->orderBy('order')->get();

        return view('artikel.category', compact('articles', 'category', 'categories'));
    }
}
