<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('articles')->orderBy('order')->get();
        return view('admin.kategori.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon'        => ['nullable', 'string', 'max:50'],
            'is_featured' => ['boolean'],
            'order'       => ['integer', 'min:0'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');

        Category::create($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', __('admin.category_created'));
    }

    public function edit(Category $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Category $kategori)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'icon'        => ['nullable', 'string', 'max:50'],
            'is_featured' => ['boolean'],
            'order'       => ['integer', 'min:0'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['is_featured'] = $request->boolean('is_featured');

        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', __('admin.category_updated'));
    }

    public function destroy(Category $kategori)
    {
        if ($kategori->articles()->count() > 0) {
            return redirect()->back()
                ->with('error', __('admin.category_has_articles'));
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', __('admin.category_deleted'));
    }
}
