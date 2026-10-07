@extends('layouts.app')

@section('title', $page->title)

@section('content')

<div class="page-header">
    <h1>{{ $page->title }}</h1>
    @if($page->slug === 'tentang-sehatin')
        <p class="page-header-typed" data-page-header-typed aria-live="off">{{ __('app.about_subtitle') }}</p>
    @endif
</div>

<div class="breadcrumb">
    <div class="breadcrumb-inner">
        <a href="{{ route('home') }}">{{ __('app.breadcrumb_home') }}</a>
        <span class="sep">›</span>
        <span>{{ $page->title }}</span>
    </div>
</div>

<div class="static-content">
    {!! $page->content !!}
</div>
@endsection
