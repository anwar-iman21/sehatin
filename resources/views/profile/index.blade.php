@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <h1 class="section-title">{{ __('app.dashboard_title') }}</h1>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary"><i class="fas fa-pen"></i> {{ __('app.edit_profile') }}</a>
        </div>

        <div class="card">
            <div class="card-body">
                @if($user->avatar)
                    <img
                        src="{{ \Illuminate\Support\Str::startsWith($user->avatar, ['http://', 'https://']) ? $user->avatar : asset('storage/'.$user->avatar) }}"
                        alt="{{ __('app.avatar_alt', ['name' => $user->name]) }}"
                        width="120"
                        height="120"
                        style="object-fit:cover;border-radius:50%;margin-bottom:1rem"
                    >
                @endif
                <h2 class="card-title">{{ $user->name }}</h2>
                <p class="card-excerpt">{{ $user->email }}</p>
            </div>
        </div>

        <div class="profile-layout">
            <section class="profile-panel" aria-labelledby="saved-articles-title">
                <div class="section-header profile-header">
                    <h2 id="saved-articles-title" class="section-title">{{ __('app.saved_articles') }}</h2>
                </div>
                <div class="profile-list">
                    @forelse($bookmarkedArticles as $article)
                        <article class="profile-item">
                            @if($article->thumbnail)
                                <img src="{{ $article->thumbnail_url }}" alt="" width="88" height="66" loading="lazy">
                            @endif
                            <div class="profile-item-copy">
                                <a href="{{ route('artikel.show', $article) }}" class="profile-item-title">{{ $article->title }}</a>
                                <p class="card-meta">{{ $article->published_at?->translatedFormat('d M Y') }}</p>
                            </div>
                            <form method="POST" action="{{ route('artikel.bookmark.remove', $article) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline" type="submit" aria-label="{{ __('app.remove_bookmark') }}">×</button>
                            </form>
                        </article>
                    @empty
                        <div class="empty-state profile-empty"><i class="fas fa-bookmark" aria-hidden="true"></i><p>{{ __('app.saved_empty') }}</p></div>
                    @endforelse
                </div>
                {{ $bookmarkedArticles->links() }}
            </section>
            <section class="profile-panel" aria-labelledby="search-history-title">
                <div class="section-header profile-header">
                    <h2 id="search-history-title" class="section-title">{{ __('app.search_history') }}</h2>
                    @if($searchHistories->isNotEmpty())
                        <form method="POST" action="{{ route('profile.history.clear') }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline" type="submit">{{ __('app.clear_all') }}</button>
                        </form>
                    @endif
                </div>
                <div class="profile-list">
                    @forelse($searchHistories as $history)
                        <article class="profile-item profile-item--history">
                            <a href="{{ route('search.index', ['q' => $history->query]) }}" class="profile-item-title profile-item-title--plain">{{ $history->query }}</a>
                            <form method="POST" action="{{ route('profile.history.destroy', $history) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline" type="submit" aria-label="{{ __('app.remove_history') }}">×</button>
                            </form>
                        </article>
                    @empty
                        <div class="empty-state profile-empty"><i class="fas fa-magnifying-glass" aria-hidden="true"></i><p>{{ __('app.history_empty') }}</p></div>
                    @endforelse
                </div>
            </section>
        </div>
    </div>
</section>
@endsection
