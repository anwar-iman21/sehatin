<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Faq;

class HomeController extends Controller
{
    public function index()
    {
        $latestArticles   = Article::published()->with(['category', 'user'])->latest('published_at')->take(5)->get();
        $categories       = Category::orderBy('order')->get();
        $featuredCategories = Category::where('is_featured', true)->orderBy('order')->take(5)->get();
        $services         = [
            [
                'name' => 'Info Obat',
                'description' => 'Kenali kegunaan, cara penggunaan, dan peringatan obat.',
                'icon' => 'fas fa-pills',
                'route' => 'obat.index',
            ],
            [
                'name' => 'Info Penyakit',
                'description' => 'Pelajari gejala, faktor risiko, dan pencegahan penyakit.',
                'icon' => 'fas fa-virus',
                'route' => 'penyakit.index',
            ],
            [
                'name' => 'Panduan Kesehatan',
                'description' => 'Baca panduan praktis untuk mendukung hidup lebih sehat.',
                'icon' => 'fas fa-book-medical',
                'route' => 'panduan.index',
            ],
        ];
        $faqs             = Faq::where('is_active', true)->orderBy('order')->take(5)->get();

        return view('home', compact(
            'latestArticles',
            'categories',
            'featuredCategories',
            'services',
            'faqs'
        ));
    }
}
