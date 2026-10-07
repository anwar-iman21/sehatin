<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use Illuminate\Http\Request;

class DrugController extends Controller
{
    public function index(Request $request)
    {
        $query = Drug::active()->orderBy('name');
        $search = $request->query('q');
        $search = is_string($search) ? trim($search) : '';
        $category = $request->query('category');
        $letter = $request->query('letter');
        $letter = is_string($letter) ? strtoupper($letter) : '';

        if ($search !== '') {
            $query->where('name', 'like', '%'.$search.'%');
        }

        if (in_array($category, ['resep', 'bebas', 'bebas_terbatas'], true)) {
            $query->where('category', $category);
        } else {
            $category = '';
        }

        if (preg_match('/^[A-Z]$/', $letter)) {
            $query->where('name', 'like', $letter.'%');
        } else {
            $letter = '';
        }

        $drugs = $query->paginate(12)->withQueryString();

        return view('layanan.obat.index', compact('drugs', 'search', 'category', 'letter'));
    }

    public function show(Drug $drug)
    {
        abort_unless($drug->is_active, 404);

        return view('layanan.obat.show', compact('drug'));
    }
}
