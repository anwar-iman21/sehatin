<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Disease;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class DiseaseController extends Controller
{
    public function index()
    {
        $diseases = Disease::query()->orderBy('name')->paginate(15);

        return view('admin.penyakit.index', compact('diseases'));
    }

    public function create()
    {
        return view('admin.penyakit.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateDisease($request);
        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);
        Disease::create($validated);

        return redirect()->route('admin.penyakit.index')->with('success', 'Informasi penyakit berhasil ditambahkan.');
    }

    public function edit(Disease $penyakit)
    {
        return view('admin.penyakit.edit', ['disease' => $penyakit]);
    }

    public function update(Request $request, Disease $penyakit)
    {
        $validated = $this->validateDisease($request);
        $validated['slug'] = $this->uniqueSlug($validated['name'], $penyakit);
        $validated['is_active'] = $request->boolean('is_active');
        $penyakit->update($validated);

        return redirect()->route('admin.penyakit.index')->with('success', 'Informasi penyakit berhasil diperbarui.');
    }

    public function destroy(Disease $penyakit)
    {
        $penyakit->delete();

        return redirect()->route('admin.penyakit.index')->with('success', 'Informasi penyakit berhasil dihapus.');
    }

    public function toggleActive(Disease $penyakit)
    {
        $penyakit->update(['is_active' => !$penyakit->is_active]);

        return back()->with('success', 'Status informasi penyakit berhasil diperbarui.');
    }

    private function validateDisease(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'overview' => ['required', 'string'],
            'symptoms' => ['nullable', 'string'],
            'causes' => ['nullable', 'string'],
            'risk_factors' => ['nullable', 'string'],
            'diagnosis' => ['nullable', 'string'],
            'treatment' => ['nullable', 'string'],
            'prevention' => ['nullable', 'string'],
            'when_to_see_doctor' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $name, ?Disease $disease = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $suffix = 2;

        while (Disease::where('slug', $slug)->when($disease, fn ($query) => $query->whereKeyNot($disease->getKey()))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        if ($slug === '') {
            throw ValidationException::withMessages(['name' => 'Nama penyakit harus menghasilkan slug yang valid.']);
        }

        return $slug;
    }
}
