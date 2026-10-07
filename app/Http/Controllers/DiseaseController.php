<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        $search = is_string($search) ? trim($search) : '';
        $diseases = Disease::active()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', '%'.$search.'%'))
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('layanan.penyakit.index', compact('diseases', 'search'));
    }

    public function show(Disease $disease)
    {
        abort_unless($disease->is_active, 404);

        return view('layanan.penyakit.show', compact('disease'));
    }
}
