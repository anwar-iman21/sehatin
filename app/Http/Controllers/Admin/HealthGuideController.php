<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthGuide;
use App\Support\HtmlSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HealthGuideController extends Controller
{
    private const CATEGORIES = ['nutrisi', 'olahraga', 'mental', 'tidur', 'kebersihan', 'lainnya'];

    public function index()
    {
        $guides = HealthGuide::query()->orderBy('order')->orderBy('title')->paginate(15);

        return view('admin.panduan.index', compact('guides'));
    }

    public function create()
    {
        return view('admin.panduan.create', ['categories' => self::CATEGORIES]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateGuide($request);
        $validated['slug'] = $this->uniqueSlug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active', true);
        HealthGuide::create($validated);

        return redirect()->route('admin.panduan.index')->with('success', 'Panduan kesehatan berhasil ditambahkan.');
    }

    public function edit(HealthGuide $panduan)
    {
        return view('admin.panduan.edit', ['guide' => $panduan, 'categories' => self::CATEGORIES]);
    }

    public function update(Request $request, HealthGuide $panduan)
    {
        $validated = $this->validateGuide($request);
        $validated['slug'] = $this->uniqueSlug($validated['title'], $panduan);
        $validated['is_active'] = $request->boolean('is_active');
        $panduan->update($validated);

        return redirect()->route('admin.panduan.index')->with('success', 'Panduan kesehatan berhasil diperbarui.');
    }

    public function destroy(HealthGuide $panduan)
    {
        $panduan->delete();

        return redirect()->route('admin.panduan.index')->with('success', 'Panduan kesehatan berhasil dihapus.');
    }

    public function toggleActive(HealthGuide $panduan)
    {
        $panduan->update(['is_active' => !$panduan->is_active]);

        return back()->with('success', 'Status panduan berhasil diperbarui.');
    }

    private function validateGuide(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:'.implode(',', self::CATEGORIES)],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:100'],
            'order' => ['required', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $validated['content'] = HtmlSanitizer::clean($validated['content']);

        return $validated;
    }

    private function uniqueSlug(string $title, ?HealthGuide $guide = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $suffix = 2;

        while (HealthGuide::where('slug', $slug)->when($guide, fn ($query) => $query->whereKeyNot($guide->getKey()))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        if ($slug === '') {
            throw ValidationException::withMessages(['title' => 'Judul panduan harus menghasilkan slug yang valid.']);
        }

        return $slug;
    }
}
