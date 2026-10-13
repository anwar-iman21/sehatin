<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Support\HtmlSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order')->get();
        return view('admin.layanan.index', compact('services'));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:500'],
            'content'     => ['nullable', 'string'],
            'icon'        => ['nullable', 'string', 'max:50'],
            'is_active'   => ['boolean'],
            'order'       => ['integer', 'min:0'],
        ]);

        $validated['content'] = HtmlSanitizer::clean($validated['content'] ?? null);

        $validated['slug']      = Str::slug($validated['name']);
        $validated['is_active'] = $request->boolean('is_active', true);

        Service::create($validated);

        return redirect()->route('admin.layanan.index')
            ->with('success', __('admin.service_created'));
    }

    public function edit(Service $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Service $layanan)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['required', 'string', 'max:500'],
            'content'     => ['nullable', 'string'],
            'icon'        => ['nullable', 'string', 'max:50'],
            'is_active'   => ['boolean'],
            'order'       => ['integer', 'min:0'],
        ]);

        $validated['content'] = HtmlSanitizer::clean($validated['content'] ?? null);

        $validated['is_active'] = $request->boolean('is_active');

        $layanan->update($validated);

        return redirect()->route('admin.layanan.index')
            ->with('success', __('admin.service_updated'));
    }

    public function destroy(Service $layanan)
    {
        $layanan->delete();

        return redirect()->route('admin.layanan.index')
            ->with('success', __('admin.service_deleted'));
    }
}
