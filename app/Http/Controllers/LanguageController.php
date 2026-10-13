<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, string $locale)
    {
        if (!in_array($locale, ['id', 'en'])) {
            abort(400);
        }

        session(['locale' => $locale]);

        if ($request->expectsJson()) {
            return response()->json(['locale' => $locale]);
        }

        return redirect()->back()->withHeaders([
            'Cache-Control' => 'no-cache, no-store',
        ]);
    }
}
