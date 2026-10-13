<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Support\HtmlSanitizer;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    public function index()
    {
        $pages = StaticPage::all();
        return view('admin.halaman.index', compact('pages'));
    }

    public function edit(StaticPage $halaman)
    {
        return view('admin.halaman.edit', compact('halaman'));
    }

    public function update(Request $request, StaticPage $halaman)
    {
        $validated = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $validated['content'] = HtmlSanitizer::clean($validated['content']);

        $halaman->update($validated);

        return redirect()->route('admin.halaman.index')
            ->with('success', __('admin.page_updated'));
    }
}
