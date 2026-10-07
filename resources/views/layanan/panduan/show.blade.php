@extends('layouts.app')

@section('title', $guide->title . ' — Panduan Kesehatan')

@section('content')
<div class="page-header"><h1>{{ $guide->title }}</h1><p class="page-header-typed" data-page-header-typed aria-live="off">{{ $guide->excerpt }}</p></div>
<div class="breadcrumb"><div class="breadcrumb-inner"><a href="{{ route('home') }}">Beranda</a><span class="sep">›</span><a href="{{ route('layanan.index') }}">Layanan</a><span class="sep">›</span><a href="{{ route('panduan.index') }}">Panduan Kesehatan</a><span class="sep">›</span><span>{{ $guide->title }}</span></div></div>

<section class="section">
    <div class="section-inner" style="display:grid;grid-template-columns:minmax(0,2fr) minmax(220px,1fr);gap:2rem;align-items:start">
        <article class="card" style="padding:clamp(1.25rem,4vw,2.5rem)">
            <span class="card-tag" style="display:inline-flex;margin-bottom:1.25rem">{{ ucfirst($guide->category) }}</span>
            <div class="article-content">{!! $guide->content !!}</div>
            <div class="disclaimer-box" style="margin-top:1.5rem"><i class="fas fa-triangle-exclamation"></i> Informasi ini bersifat edukatif dan tidak menggantikan konsultasi dengan tenaga kesehatan profesional.</div>
        </article>
        <aside class="card" style="padding:1.25rem">
            <h2 style="font-size:1rem;font-weight:700;margin-bottom:1rem">Kategori: {{ ucfirst($guide->category) }}</h2>
            <a href="{{ route('panduan.index', ['category' => $guide->category]) }}" class="btn btn-outline btn-sm" style="margin-bottom:1rem">Lihat semua kategori ini</a>
            @if($relatedGuides->isNotEmpty())
                <h3 style="font-size:.9rem;font-weight:700;margin:.75rem 0">Panduan terkait</h3>
                <div style="display:flex;flex-direction:column;gap:.7rem">
                    @foreach($relatedGuides as $related)
                        <a href="{{ route('panduan.show', $related) }}" style="font-size:.875rem;color:var(--green-700);line-height:1.5">{{ $related->title }} <i class="fas fa-arrow-right" style="font-size:.7rem"></i></a>
                    @endforeach
                </div>
            @endif
        </aside>
    </div>
</section>
@endsection

@push('styles')
<style>
    .article-content { color:var(--slate-700);font-size:.95rem;line-height:1.85; }
    .article-content h2,.article-content h3 { color:var(--slate-800);margin:1.5rem 0 .65rem; }
    .article-content p { margin-bottom:1rem; }
    .article-content ul,.article-content ol { margin:0 0 1rem 1.4rem; }
    @media(max-width:768px) { .section-inner[style*="grid-template-columns"] { grid-template-columns:1fr!important; } }
</style>
@endpush
