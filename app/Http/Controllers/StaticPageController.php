<?php

namespace App\Http\Controllers;

use App\Models\StaticPage;

class StaticPageController extends Controller
{
    public function show(string $slug)
    {
        $page = StaticPage::where('slug', $slug)->firstOrFail();
        return view('pages.static', compact('page'));
    }
}
