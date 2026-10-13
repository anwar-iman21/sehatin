@extends('layouts.app')

@section('title', __('app.home'))

@section('content')

{{-- HERO --}}
<section class="hero">
    <div class="hero-art" aria-hidden="true">
        <span class="hero-orb hero-orb--left"></span>
        <span class="hero-orb hero-orb--right"></span>
        <span class="hero-ring"></span>
        <svg class="hero-silhouette hero-silhouette--leaf" viewBox="0 0 100 100" fill="none">
            <path d="M84 15C49 14 23 25 17 49 12 69 28 83 46 77c22-7 34-32 38-62Z" fill="currentColor"/>
            <path d="M19 82c13-22 28-37 52-54" stroke="white" stroke-opacity=".6" stroke-width="3" stroke-linecap="round"/>
        </svg>
        <svg class="hero-silhouette hero-silhouette--heart" viewBox="0 0 100 100" fill="none">
            <path d="M50 83 18 53C-5 29 28 7 50 31 72 7 105 29 82 53L50 83Z" fill="currentColor"/>
            <path d="M18 50h18l8-14 12 29 9-15h18" stroke="white" stroke-opacity=".72" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <svg class="hero-silhouette hero-silhouette--plus" viewBox="0 0 100 100" fill="none">
            <path d="M38 10h24v28h28v24H62v28H38V62H10V38h28V10Z" fill="currentColor"/>
        </svg>
        <svg class="hero-silhouette hero-silhouette--pulse" viewBox="0 0 140 70" fill="none">
            <path d="M4 38h28l14-25 23 49 18-36 11 12h38" stroke="currentColor" stroke-width="8" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>
    <div class="hero-inner">
        <div class="hero-kicker"><i class="fas fa-leaf"></i> {{ __('app.tagline') }}</div>
        <h1>{{ __('app.hero_title') }}</h1>
        <p>{{ __('app.hero_subtitle') }}</p>
        <div class="hero-typed-line" aria-hidden="true">
            {{ __('app.hero_prompt') }}
            <span class="hero-typed" data-hero-typed>{{ __('app.hero_phrases.0') }}</span>
        </div>
        <div class="hero-btns">
            <a href="{{ route('artikel.index') }}" class="btn btn-primary">
                <i class="fas fa-book-open"></i> {{ __('app.hero_cta') }}
            </a>
            <a href="{{ route('layanan.index') }}" class="btn btn-outline">
                <i class="fas fa-stethoscope"></i> {{ __('app.hero_cta2') }}
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script data-page-script>
    (() => {
        const typedText = document.querySelector('[data-hero-typed]');
        if (!typedText) return;

        const phrases = @json(__('app.hero_phrases'));
        const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (reduceMotion || !Array.isArray(phrases) || phrases.length < 2) return;

        let phraseIndex = 0;
        let characterIndex = phrases[0].length;
        let deleting = true;

        const typeNext = () => {
            const phrase = phrases[phraseIndex];
            characterIndex += deleting ? -1 : 1;
            typedText.textContent = phrase.slice(0, characterIndex);

            let delay = deleting ? 38 : 72;
            if (characterIndex === 0) {
                deleting = false;
                phraseIndex = (phraseIndex + 1) % phrases.length;
                delay = 260;
            } else if (characterIndex === phrases[phraseIndex].length) {
                deleting = true;
                delay = 1450;
            }

            window.setTimeout(typeNext, delay);
        };

        window.setTimeout(typeNext, 1450);
    })();
</script>
@endpush

{{-- LATEST ARTICLES --}}
<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <h2 class="section-title">{{ __('app.latest_articles') }}</h2>
            <a href="{{ route('artikel.index') }}" class="section-link">{{ __('app.view_all_articles') }} →</a>
        </div>
        @if($latestArticles->count())
            <div class="grid-3">
                @foreach($latestArticles->take(3) as $article)
                    <article class="card">
                        <a href="{{ route('artikel.show', $article) }}">
                            <img class="card-img" src="{{ $article->thumbnail_url }}" alt="{{ $article->title }}">
                        </a>
                        <div class="card-body">
                            <div class="card-meta">
                                <span class="card-tag">{{ $article->category->name }}</span>
                                <span>{{ $article->published_at?->diffForHumans() }}</span>
                            </div>
                            <h3 class="card-title">
                                <a href="{{ route('artikel.show', $article) }}">{{ $article->title }}</a>
                            </h3>
                            <p class="card-excerpt">{{ $article->excerpt }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('artikel.show', $article) }}" class="btn btn-sm btn-outline">
                                {{ __('app.read_more') }} →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-newspaper"></i>
                <p>{{ __('app.no_articles') }}</p>
            </div>
        @endif
    </div>
</section>

{{-- FEATURED CATEGORIES --}}
<section class="section section-alt">
    <div class="section-inner">
        <div class="section-header">
            <h2 class="section-title">{{ __('app.featured_categories') }}</h2>
            <a href="{{ route('artikel.index') }}" class="section-link">{{ __('app.view_all') }} →</a>
        </div>
        <div class="grid-5">
            @forelse($featuredCategories as $cat)
                <a href="{{ route('artikel.category', $cat) }}" class="card cat-card">
                    <div class="cat-icon">
                        <i class="{{ $cat->icon ?? 'fas fa-folder' }}"></i>
                    </div>
                    <div>
                        <p class="cat-name">{{ $cat->name }}</p>
                        <p class="cat-count">{{ $cat->published_articles_count ?? $cat->articles()->where('status','published')->count() }} artikel</p>
                    </div>
                </a>
            @empty
                <p style="color:var(--slate-400)">Belum ada kategori.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- SERVICES --}}
<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <h2 class="section-title">{{ __('app.our_services') }}</h2>
            <a href="{{ route('layanan.index') }}" class="section-link">{{ __('app.view_all_services') }} →</a>
        </div>
        <div class="grid-3">
            @foreach($services as $svc)
                <a href="{{ route($svc['route']) }}" class="card svc-card">
                    <div class="svc-icon"><i class="{{ $svc['icon'] }}"></i></div>
                    <p class="svc-name">{{ $svc['name'] }}</p>
                    <p class="svc-desc">{{ $svc['description'] }}</p>
                    <span class="btn btn-sm btn-outline" style="margin-top:auto;width:fit-content">{{ __('app.learn_more') }} →</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="section section-alt">
    <div class="section-inner">
        <div class="section-header">
            <h2 class="section-title">{{ __('app.faq_section') }}</h2>
            <a href="{{ route('faq') }}" class="section-link">{{ __('app.view_all') }} →</a>
        </div>
        @if($faqs->count())
            <div class="faq-list">
                @foreach($faqs as $i => $faq)
                    <div class="faq-item">
                        <button class="faq-q" aria-expanded="{{ $i === 0 ? 'true' : 'false' }}">
                            {{ $faq->question }}
                            <i class="fas fa-plus faq-icon"></i>
                        </button>
                        <div class="faq-a {{ $i === 0 ? 'open' : '' }}"><div>{{ $faq->answer }}</div></div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-question-circle"></i>
                <p>{{ __('app.faq_not_found') }}</p>
            </div>
        @endif
    </div>
</section>

@endsection
