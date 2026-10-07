<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Service;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'articles'   => Article::count(),
            'published'  => Article::where('status', 'published')->count(),
            'drafts'     => Article::where('status', 'draft')->count(),
            'categories' => Category::count(),
            'services'   => Service::count(),
            'faqs'       => Faq::count(),
            'users'      => User::where('role', 'user')->count(),
        ];

        $recentArticles = Article::with(['category', 'user'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentArticles'));
    }
}
