@extends('layouts.app')

@section('title', __('app.sdg_title'))

@section('content')
<header class="page-header">
    <h1>{{ __('app.sdg_title') }}</h1>
    <p>{{ __('app.sdg_subtitle') }}</p>
</header>
<main class="section">
    <div class="section-inner">
        <div class="grid-3">
            <article class="card" style="padding:1.5rem">
                <span aria-hidden="true" style="display:inline-grid;place-items:center;width:3.4rem;height:3.4rem;border-radius:50%;background:#b91c1c;color:#fff;font-weight:800;font-size:1.2rem">3</span>
                <h2 class="card-title" style="margin-top:1rem">{{ __('app.sdg3_title') }}</h2>
                <p class="card-excerpt">{{ __('app.sdg3_description') }}</p>
                <ul style="margin:1rem 0 0 1.2rem">
                    <li><a class="section-link" href="{{ route('artikel.index') }}">{{ __('app.articles') }}</a></li>
                    <li><a class="section-link" href="{{ route('health-tools.mental-quiz') }}">{{ __('app.mental_quiz_title') }}</a></li>
                    <li><a class="section-link" href="{{ route('consultation.index') }}">{{ __('app.consultation_title') }}</a></li>
                </ul>
            </article>
            <article class="card" style="padding:1.5rem">
                <span aria-hidden="true" style="display:inline-grid;place-items:center;width:3.4rem;height:3.4rem;border-radius:50%;background:#c2410c;color:#fff;font-weight:800;font-size:1.2rem">9</span>
                <h2 class="card-title" style="margin-top:1rem">{{ __('app.sdg9_title') }}</h2>
                <p class="card-excerpt">{{ __('app.sdg9_description') }}</p>
                <ul style="margin:1rem 0 0 1.2rem">
                    <li><a class="section-link" href="{{ route('search.index') }}">{{ __('app.search_all') }}</a></li>
                    <li><a class="section-link" href="{{ route('consultation.index') }}">{{ __('app.consultation_title') }}</a></li>
                    <li><a class="section-link" href="{{ route('home') }}">{{ __('app.pwa_title') }}</a></li>
                </ul>
            </article>
            <article class="card" style="padding:1.5rem">
                <span aria-hidden="true" style="display:inline-grid;place-items:center;width:3.4rem;height:3.4rem;border-radius:50%;background:#7e22ce;color:#fff;font-weight:800;font-size:1.2rem">10</span>
                <h2 class="card-title" style="margin-top:1rem">{{ __('app.sdg10_title') }}</h2>
                <p class="card-excerpt">{{ __('app.sdg10_description') }}</p>
                <ul style="margin:1rem 0 0 1.2rem">
                    <li><a class="section-link" href="{{ route('health-tools.bmi') }}">{{ __('app.bmi_title') }}</a></li>
                    <li><a class="section-link" href="{{ route('community.index') }}">{{ __('app.community_title') }}</a></li>
                    <li><button class="section-link" type="button" data-data-saver-toggle>{{ __('app.data_saver') }}</button></li>
                </ul>
            </article>
        </div>
    </div>
</main>
@endsection
