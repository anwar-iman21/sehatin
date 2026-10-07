@extends('layouts.app')

@section('title', $service->name)

@section('content')

<div class="breadcrumb">
    <div class="breadcrumb-inner">
        <a href="{{ route('home') }}">{{ __('app.breadcrumb_home') }}</a>
        <span class="sep">›</span>
        <a href="{{ route('layanan.index') }}">{{ __('app.services') }}</a>
        <span class="sep">›</span>
        <span>{{ $service->name }}</span>
    </div>
</div>

<div style="max-width:900px;margin:0 auto;padding:2.5rem 1.25rem">

    {{-- Hero Card --}}
    <div style="background:linear-gradient(135deg,var(--green-700),var(--green-500));border-radius:var(--radius);padding:2.5rem;margin-bottom:2rem;display:flex;align-items:center;gap:1.5rem;color:white">
        <div style="width:72px;height:72px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <i class="{{ $service->icon ?? 'fas fa-stethoscope' }}" style="font-size:2rem"></i>
        </div>
        <div>
            <h1 style="font-family:'Merriweather',serif;font-size:clamp(1.5rem,3vw,2rem);margin-bottom:.5rem">{{ $service->name }}</h1>
            <p class="page-header-typed" data-page-header-typed aria-live="off" style="opacity:.9;font-size:1rem;line-height:1.6">{{ $service->description }}</p>
        </div>
    </div>

    {{-- Content --}}
    @if($service->content)
        <div class="static-content" style="margin:0">
            {!! $service->content !!}
        </div>
    @endif

    <div class="disclaimer-box" style="margin-top:2rem">
        <i class="fas fa-info-circle"></i>
        <strong>Disclaimer:</strong> {{ __('app.disclaimer') }}
    </div>

    <div style="margin-top:2rem">
        <a href="{{ route('layanan.index') }}" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i> {{ __('app.back_to_services') }}
        </a>
    </div>
</div>
@endsection
