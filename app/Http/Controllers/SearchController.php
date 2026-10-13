<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Disease;
use App\Models\Drug;
use App\Models\HealthGuide;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->query('q', ''));
        abort_if(mb_strlen($query) > 200, 422);

        $groups = $query === '' ? collect() : $this->search($query);

        if ($query !== '' && $request->user()) {
            $userId = $request->user()->id;
            $now = now();
            SearchHistory::query()->upsert(
                [['user_id' => $userId, 'query' => $query, 'created_at' => $now, 'updated_at' => $now]],
                ['user_id', 'query'],
                ['updated_at']
            );

            $recentHistoryIds = SearchHistory::query()
                ->where('user_id', $userId)
                ->latest('updated_at')
                ->limit(20)
                ->pluck('id');
            SearchHistory::query()
                ->where('user_id', $userId)
                ->whereNotIn('id', $recentHistoryIds)
                ->delete();
        }

        return view('search.index', compact('query', 'groups'));
    }

    public function suggestions(Request $request)
    {
        $query = trim((string) $request->query('q', ''));
        if (mb_strlen($query) < 2 || mb_strlen($query) > 200) {
            return response()->json(['suggestions' => []]);
        }

        $suggestions = $this->search($query)
            ->flatten(1)
            ->take(8)
            ->map(fn (array $item): array => ['title' => $item['title'], 'url' => $item['url']])
            ->values();

        return response()->json(['suggestions' => $suggestions]);
    }

    private function search(string $query): Collection
    {
        $like = '%'.addcslashes($query, '%_\\').'%';

        return collect([
            __('app.articles') => Article::published()->where('title', 'like', $like)
                ->latest('published_at')->limit(5)->get()
                ->map(fn (Article $item): array => ['title' => $item->title, 'excerpt' => $item->excerpt, 'url' => route('artikel.show', $item)]),
            __('app.diseases') => Disease::active()->where(fn ($builder) => $builder
                ->where('name', 'like', $like)
                ->orWhere('overview', 'like', $like)
                ->orWhere('symptoms', 'like', $like))
                ->orderBy('name')->limit(5)->get()
                ->map(fn (Disease $item): array => ['title' => $item->name, 'excerpt' => $item->overview, 'url' => route('penyakit.show', $item)]),
            __('app.drugs') => Drug::active()->where(fn ($builder) => $builder
                ->where('name', 'like', $like)->orWhere('generic_name', 'like', $like)->orWhere('indication', 'like', $like))
                ->orderBy('name')->limit(5)->get()
                ->map(fn (Drug $item): array => ['title' => $item->name, 'excerpt' => $item->indication, 'url' => route('obat.show', $item)]),
            __('app.guides') => HealthGuide::active()->where(fn ($builder) => $builder
                ->where('title', 'like', $like)->orWhere('excerpt', 'like', $like)->orWhere('content', 'like', $like))
                ->orderBy('order')->limit(5)->get()
                ->map(fn (HealthGuide $item): array => ['title' => $item->title, 'excerpt' => $item->excerpt, 'url' => route('panduan.show', $item)]),
        ])->filter(fn (Collection $items): bool => $items->isNotEmpty());
    }
}
