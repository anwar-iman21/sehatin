@extends('layouts.app')

@section('title', $article->title)
@section('meta_description', $article->meta_description ?? $article->excerpt)

@section('og')
<meta property="og:title" content="{{ $article->title }}">
<meta property="og:description" content="{{ $article->excerpt }}">
<meta property="og:image" content="{{ $article->thumbnail_url }}">
<meta property="og:type" content="article">
@endsection

@section('content')

<div class="breadcrumb">
    <div class="breadcrumb-inner">
        <a href="{{ route('home') }}">{{ __('app.breadcrumb_home') }}</a>
        <span class="sep">›</span>
        <a href="{{ route('artikel.index') }}">{{ __('app.breadcrumb_article') }}</a>
        <span class="sep">›</span>
        <a href="{{ route('artikel.category', $article->category) }}">{{ $article->category->name }}</a>
        <span class="sep">›</span>
        <span style="max-width:250px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $article->title }}</span>
    </div>
</div>

<div class="article-page">
    {{-- MAIN CONTENT --}}
    <article>
        <img class="article-hero-img" src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}">

        <div class="article-meta">
            <span class="card-tag">{{ $article->category->name }}</span>
            <span><i class="fas fa-user" style="color:var(--green-600)"></i> {{ __('app.author') }}: {{ $article->user?->name ?? $article->author ?? __('app.article_author_unavailable') }}</span>
            <span><i class="fas fa-calendar" style="color:var(--green-600)"></i> {{ $article->published_at?->translatedFormat('d F Y') }}</span>
            <span><i class="fas fa-user-doctor" style="color:var(--green-600)"></i> {{ __('app.medical_reviewer') }}: {{ $article->reviewer_name ?: __('app.not_medically_reviewed') }}</span>
            <span><i class="fas fa-clipboard-check" style="color:var(--green-600)"></i> {{ __('app.last_reviewed') }}: {{ $article->last_reviewed_at?->translatedFormat('d F Y') ?? __('app.review_date_unavailable') }}</span>
        </div>

        <h1 class="article-title">{{ $article->title }}</h1>

        <div class="article-actions">
            @auth
                @php($isBookmarked = auth()->user()->bookmarkedArticles()->whereKey($article->id)->exists())
                <button type="button" class="btn btn-sm btn-outline" data-bookmark-article="{{ $article->id }}"
                        data-bookmark-url="{{ route('artikel.bookmark', $article) }}"
                        data-bookmarked="{{ $isBookmarked ? 'true' : 'false' }}"
                        data-save-label="{{ __('app.save_article') }}"
                        data-saved-label="{{ __('app.article_saved') }}"
                        data-error-message="{{ __('app.bookmark_error') }}"
                        aria-pressed="{{ $isBookmarked ? 'true' : 'false' }}">
                    <i class="fas fa-bookmark" aria-hidden="true"></i>
                    <span>{{ $isBookmarked ? __('app.article_saved') : __('app.save_article') }}</span>
                </button>
            @else
                <a class="btn btn-sm btn-outline" href="{{ route('login') }}">
                    <i class="fas fa-bookmark" aria-hidden="true"></i> {{ __('app.login_to_save') }}
                </a>
            @endauth
            <button type="button" class="btn btn-sm btn-outline" data-speak-article aria-pressed="false">
                <i class="fas fa-volume-high" aria-hidden="true"></i>
                <span>{{ __('app.listen') }}</span>
            </button>
            <button type="button" class="btn btn-sm btn-outline" data-stop-article aria-label="Stop">
                <i class="fas fa-stop" aria-hidden="true"></i>
                <span>{{ __('app.stop') }}</span>
            </button>
        </div>

        @if($article->excerpt)
            <p style="font-size:1.1rem;color:var(--slate-500);line-height:1.7;margin-bottom:2rem;font-style:italic;border-left:3px solid var(--green-400);padding-left:1rem">
                {{ $article->excerpt }}
            </p>
        @endif

        <div class="article-body">
            {!! $article->content !!}
        </div>

        <section aria-labelledby="article-references-title" style="margin-top:2rem">
            <h2 id="article-references-title" class="section-title" style="font-size:1.2rem">{{ __('app.references') }}</h2>
            @if($article->references_json)
                <ol style="margin:.75rem 0 0 1.5rem;color:var(--slate-600)">
                    @foreach($article->references_json as $reference)
                        @if(is_array($reference) && filled($reference['title'] ?? null))
                            <li style="margin:.4rem 0">
                                @if(filled($reference['url'] ?? null))
                                    <a href="{{ $reference['url'] }}" target="_blank" rel="noopener noreferrer">{{ $reference['title'] }}</a>
                                @else
                                    {{ $reference['title'] }}
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ol>
            @else
                <p style="margin-top:.75rem">{{ __('app.references_unavailable') }}</p>
            @endif
        </section>

        {{-- DISCLAIMER --}}
        <div class="disclaimer-box" style="margin-top:2.5rem">
            <i class="fas fa-info-circle"></i>
            <strong>{{ __('app.medical_disclaimer_title') }}:</strong> {{ __('app.disclaimer') }}
        </div>

        {{-- RELATED ARTICLES --}}
        @if($related->count())
            <div style="margin-top:3rem">
                <h2 style="font-family:'Merriweather',serif;font-size:1.3rem;color:var(--slate-800);margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:2px solid var(--green-100)">
                    {{ __('app.related_articles') }}
                </h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.25rem">
                    @foreach($related as $rel)
                        <a href="{{ route('artikel.show', $rel) }}" class="card" style="text-decoration:none">
                            <img class="card-img" src="{{ $rel->thumbnail_url }}" alt="{{ $rel->title }}" loading="lazy">
                            <div class="card-body">
                                <div class="card-meta">
                                    <span>{{ $rel->published_at?->translatedFormat('d M Y') }}</span>
                                </div>
                                <h3 class="card-title" style="font-size:.9rem">{{ $rel->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </article>

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-box">
            <p class="sidebar-title"><i class="fas fa-folder" style="color:var(--green-600)"></i> {{ __('app.category') }}</p>
            <a href="{{ route('artikel.category', $article->category) }}"
               style="display:inline-flex;align-items:center;gap:.5rem;background:var(--green-50);color:var(--green-700);padding:.5rem .9rem;border-radius:.5rem;font-size:.875rem;font-weight:600">
                <i class="{{ $article->category->icon ?? 'fas fa-folder' }}"></i>
                {{ $article->category->name }}
            </a>
        </div>

        <div class="sidebar-box">
            <p class="sidebar-title"><i class="fas fa-share-alt" style="color:var(--green-600)"></i> {{ __('app.share_article') }}</p>
            <div style="display:flex;flex-direction:column;gap:.5rem">
                <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}"
                   target="_blank" rel="noopener"
                   style="display:flex;align-items:center;gap:.6rem;padding:.5rem .9rem;border-radius:.5rem;background:#25D366;color:white;font-size:.85rem;font-weight:600;text-decoration:none">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}"
                   target="_blank" rel="noopener"
                   style="display:flex;align-items:center;gap:.6rem;padding:.5rem .9rem;border-radius:.5rem;background:#1DA1F2;color:white;font-size:.85rem;font-weight:600;text-decoration:none">
                    <i class="fab fa-twitter"></i> Twitter / X
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                   target="_blank" rel="noopener"
                   style="display:flex;align-items:center;gap:.6rem;padding:.5rem .9rem;border-radius:.5rem;background:#1877F2;color:white;font-size:.85rem;font-weight:600;text-decoration:none">
                    <i class="fab fa-facebook"></i> Facebook
                </a>
            </div>
        </div>

        <div class="sidebar-box">
            <p class="sidebar-title"><i class="fas fa-tag" style="color:var(--green-600)"></i> {{ __('app.article_categories') }}</p>
            <div style="display:flex;flex-wrap:wrap;gap:.4rem">
                @foreach(\App\Models\Category::orderBy('order')->get() as $cat)
                    <a href="{{ route('artikel.category', $cat) }}"
                       style="padding:.3rem .7rem;border-radius:999px;font-size:.78rem;font-weight:600;background:var(--green-50);color:var(--green-700);border:1px solid var(--green-200);transition:all .15s"
                       onmouseover="this.style.background='var(--green-600)';this.style.color='white'"
                       onmouseout="this.style.background='var(--green-50)';this.style.color='var(--green-700)'">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </aside>
</div>
@endsection
