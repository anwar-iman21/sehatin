@extends('layouts.app')

@section('title', __('app.faq'))

@section('content')

<div class="page-header">
    <h1>{{ __('app.faq_section') }}</h1>
    <p class="page-header-typed" data-page-header-typed aria-live="off">{{ __('app.faq_subtitle') }}</p>
</div>

<div class="breadcrumb">
    <div class="breadcrumb-inner">
        <a href="{{ route('home') }}">{{ __('app.breadcrumb_home') }}</a>
        <span class="sep">›</span>
        <span>{{ __('app.faq') }}</span>
    </div>
</div>

<section class="section">
    <div class="section-inner">
        @if($faqs->count())
            <div class="faq-list">
                @foreach($faqs as $i => $faq)
                    <div class="faq-item">
                        <button class="faq-q" aria-expanded="{{ $i === 0 ? 'true' : 'false' }}">
                            {{ $faq->question }}
                            <i class="fas fa-plus faq-icon"></i>
                        </button>
                        <div class="faq-a {{ $i === 0 ? 'open' : '' }}">
                            <div style="line-height:1.75">{!! nl2br(e($faq->answer)) !!}</div>
                        </div>
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
