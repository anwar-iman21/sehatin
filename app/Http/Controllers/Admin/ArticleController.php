<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Support\HtmlSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['category', 'user'])->latest()->paginate(15);
        return view('admin.artikel.index', compact('articles'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.artikel.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'category_id'      => ['required', 'exists:categories,id'],
            'excerpt'          => ['nullable', 'string', 'max:500'],
            'content'          => ['required', 'string'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'thumbnail'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'           => ['required', 'in:draft,published'],
        ]);

        $validated['content'] = HtmlSanitizer::clean($validated['content']);

        $validated['user_id'] = auth()->id();
        $validated['slug']    = Str::slug($validated['title']);

        // Handle duplicate slugs
        $slug  = $validated['slug'];
        $count = Article::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $validated['slug'] = $slug . '-' . ($count + 1);
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        Article::create($validated);

        return redirect()->route('admin.artikel.index')
            ->with('success', __('admin.article_created'));
    }

    public function edit(Article $artikel)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.artikel.edit', compact('artikel', 'categories'));
    }

    public function update(Request $request, Article $artikel)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'category_id'      => ['required', 'exists:categories,id'],
            'excerpt'          => ['nullable', 'string', 'max:500'],
            'content'          => ['required', 'string'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'thumbnail'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'status'           => ['required', 'in:draft,published'],
        ]);

        $validated['content'] = HtmlSanitizer::clean($validated['content']);

        if ($request->hasFile('thumbnail')) {
            if ($artikel->thumbnail) {
                Storage::disk('public')->delete($artikel->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('articles', 'public');
        }

        // Set published_at when first publishing
        if ($validated['status'] === 'published' && $artikel->status !== 'published') {
            $validated['published_at'] = now();
        }

        $artikel->update($validated);

        return redirect()->route('admin.artikel.index')
            ->with('success', __('admin.article_updated'));
    }

    public function destroy(Article $artikel)
    {
        if ($artikel->thumbnail) {
            Storage::disk('public')->delete($artikel->thumbnail);
        }
        $artikel->delete();

        return redirect()->route('admin.artikel.index')
            ->with('success', __('admin.article_deleted'));
    }

    public function toggleStatus(Article $artikel)
    {
        if ($artikel->status === 'published') {
            $artikel->update(['status' => 'draft', 'published_at' => null]);
            $msg = __('admin.article_unpublished');
        } else {
            $artikel->update(['status' => 'published', 'published_at' => now()]);
            $msg = __('admin.article_published');
        }

        return redirect()->back()->with('success', $msg);
    }
}
