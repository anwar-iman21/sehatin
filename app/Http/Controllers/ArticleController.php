<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

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

        return response()
            ->view('artikel.show', compact('article', 'related'))
            ->header('Cache-Control', auth()->check()
                ? 'private, no-store'
                : 'public, max-age=0, must-revalidate');
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

    public function toggleBookmark(Request $request, Article $article)
    {
        abort_unless($article->status === 'published', 404);
        $bookmark = $request->user()->bookmarkedArticles()->toggle($article->id);

        return response()->json(['bookmarked' => $bookmark['attached'] !== []]);
    }

    public function removeBookmark(Request $request, Article $article)
    {
        $request->user()->bookmarkedArticles()->detach($article->id);

        return back()->with('success', __('app.bookmark_removed'));
    }
}
