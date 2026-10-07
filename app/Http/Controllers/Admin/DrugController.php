<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class DrugController extends Controller
{
    private const CATEGORIES = ['resep', 'bebas', 'bebas_terbatas'];
    private const FORMS = ['tablet', 'kapsul', 'sirup', 'salep', 'injeksi', 'tetes', 'serbuk', 'inhaler'];

    public function index()
    {
        $drugs = Drug::query()->orderBy('name')->paginate(15);

        return view('admin.obat.index', compact('drugs'));
    }

    public function create()
    {
        return view('admin.obat.create', ['categories' => self::CATEGORIES, 'forms' => self::FORMS]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateDrug($request);
        $validated['slug'] = $this->uniqueSlug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        Drug::create($validated);

        return redirect()->route('admin.obat.index')->with('success', 'Informasi obat berhasil ditambahkan.');
    }

    public function edit(Drug $obat)
    {
        return view('admin.obat.edit', [
            'drug' => $obat,
            'categories' => self::CATEGORIES,
            'forms' => self::FORMS,
        ]);
    }

    public function update(Request $request, Drug $obat)
    {
        $validated = $this->validateDrug($request);
        $validated['slug'] = $this->uniqueSlug($validated['name'], $obat);
        $validated['is_active'] = $request->boolean('is_active');
        $obat->update($validated);

        return redirect()->route('admin.obat.index')->with('success', 'Informasi obat berhasil diperbarui.');
    }

    public function destroy(Drug $obat)
    {
        $obat->delete();

        return redirect()->route('admin.obat.index')->with('success', 'Informasi obat berhasil dihapus.');
    }

    public function toggleActive(Drug $obat)
    {
        $obat->update(['is_active' => !$obat->is_active]);

        return back()->with('success', 'Status informasi obat berhasil diperbarui.');
    }

    private function validateDrug(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'generic_name' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'in:'.implode(',', self::CATEGORIES)],
            'form' => ['required', 'in:'.implode(',', self::FORMS)],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'indication' => ['nullable', 'string'],
            'dosage' => ['nullable', 'string'],
            'how_to_use' => ['nullable', 'string'],
            'side_effects' => ['nullable', 'string'],
            'contraindication' => ['nullable', 'string'],
            'warning' => ['nullable', 'string'],
            'price_range' => ['nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
    }

    private function uniqueSlug(string $name, ?Drug $drug = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $suffix = 2;

        while (Drug::where('slug', $slug)->when($drug, fn ($query) => $query->whereKeyNot($drug->getKey()))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        if ($slug === '') {
            throw ValidationException::withMessages(['name' => 'Nama obat harus menghasilkan slug yang valid.']);
        }

        return $slug;
    }
}
