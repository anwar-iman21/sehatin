<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order')->get();
        return view('admin.faq.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faq.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question'  => ['required', 'string', 'max:500'],
            'answer'    => ['required', 'string'],
            'is_active' => ['boolean'],
            'order'     => ['integer', 'min:0'],
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Faq::create($validated);

        return redirect()->route('admin.faq.index')
            ->with('success', __('admin.faq_created'));
    }

    public function edit(Faq $faq)
    {
        return view('admin.faq.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'question'  => ['required', 'string', 'max:500'],
            'answer'    => ['required', 'string'],
            'is_active' => ['boolean'],
            'order'     => ['integer', 'min:0'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $faq->update($validated);

        return redirect()->route('admin.faq.index')
            ->with('success', __('admin.faq_updated'));
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faq.index')
            ->with('success', __('admin.faq_deleted'));
    }
}
