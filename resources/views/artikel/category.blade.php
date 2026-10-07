@extends('layouts.app')

@section('title', $category->name . ' — ' . __('app.articles'))

@section('content')

<div class="page-header">
    <h1>{{ $category->name }}</h1>
    <p class="page-header-typed" data-page-header-typed aria-live="off">{{ $category->description ?? __('app.articles') }}</p>
</div>

<div class="breadcrumb">
    <div class="breadcrumb-inner">
        <a href="{{ route('home') }}">{{ __('app.breadcrumb_home') }}</a>
        <span class="sep">›</span>
        <a href="{{ route('artikel.index') }}">{{ __('app.breadcrumb_article') }}</a>
        <span class="sep">›</span>
        <span>{{ $category->name }}</span>
    </div>
</div>

<div style="max-width:1200px;margin:0 auto;padding:2.5rem 1.25rem;display:grid;grid-template-columns:240px 1fr;gap:2.5rem;align-items:start">

    {{-- SIDEBAR --}}
    <aside>
        <div class="sidebar-box">
            <p class="sidebar-title"><i class="fas fa-tags" style="color:var(--green-600)"></i> {{ __('app.article_categories') }}</p>
            <ul style="list-style:none;display:flex;flex-direction:column;gap:.3rem">
                <li>
                    <a href="{{ route('artikel.index') }}" style="display:flex;justify-content:space-between;padding:.45rem .75rem;border-radius:.45rem;font-size:.875rem;color:var(--slate-700);transition:background .15s"
                       onmouseover="this.style.background='var(--green-50)'" onmouseout="this.style.background=''">
                        {{ __('app.all_categories') }}
                    </a>
                </li>
                @foreach($categories as $cat)
                    <li>
                        <a href="{{ route('artikel.category', $cat) }}"
                           style="display:flex;justify-content:space-between;align-items:center;padding:.45rem .75rem;border-radius:.45rem;font-size:.875rem;transition:all .15s;{{ $category->id === $cat->id ? 'background:var(--green-600);color:var(--white);font-weight:600' : 'color:var(--slate-700)' }}">
                            <span>{{ $cat->name }}</span>
                            <span style="font-size:.75rem;opacity:.7">({{ $cat->published_articles_count ?? 0 }})</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </aside>

    {{-- MAIN --}}
    <main>
        @if($articles->count())
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem">
                @foreach($articles as $article)
                    <article class="card">
                        <a href="{{ route('artikel.show', $article) }}">
                            <img class="card-img" src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}" loading="lazy">
                        </a>
                        <div class="card-body">
                            <div class="card-meta">
                                <span class="card-tag">{{ $category->name }}</span>
                                <span>{{ $article->published_at?->format('d M Y') }}</span>
                            </div>
                            <h3 class="card-title">
                                <a href="{{ route('artikel.show', $article) }}">{{ $article->title }}</a>
                            </h3>
                            <p class="card-excerpt">{{ $article->excerpt }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('artikel.show', $article) }}" class="btn btn-sm btn-outline">{{ __('app.read_more') }} →</a>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="pagination-wrap">{{ $articles->links() }}</div>
        @else
            <div class="empty-state">
                <i class="fas fa-newspaper"></i>
                <p>{{ __('app.no_articles') }}</p>
            </div>
        @endif
    </main>
</div>

@push('styles')
<style>
@media(max-width:768px){div[style*="grid-template-columns:240px"]{grid-template-columns:1fr!important}aside{order:2}main{order:1}}
</style>
@endpush
@endsection
