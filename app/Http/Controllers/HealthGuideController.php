<?php

namespace App\Http\Controllers;

use App\Models\HealthGuide;
use Illuminate\Http\Request;

class HealthGuideController extends Controller
{
    private const CATEGORIES = ['nutrisi', 'olahraga', 'mental', 'tidur', 'kebersihan', 'lainnya'];

    public function index(Request $request)
    {
        $category = $request->query('category');
        if (!in_array($category, self::CATEGORIES, true)) {
            $category = '';
        }

        $guides = HealthGuide::active()
            ->when($category !== '', fn ($query) => $query->where('category', $category))
            ->orderBy('order')
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        return view('layanan.panduan.index', compact('guides', 'category'));
    }

    public function show(HealthGuide $guide)
    {
        abort_unless($guide->is_active, 404);

        $relatedGuides = HealthGuide::active()
            ->where('category', $guide->category)
            ->whereKeyNot($guide->getKey())
            ->orderBy('order')
            ->limit(5)
            ->get();

        return view('layanan.panduan.show', compact('guide', 'relatedGuides'));
    }
}
