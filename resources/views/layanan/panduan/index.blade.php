@extends('layouts.app')

@section('title', 'Panduan Kesehatan')

@section('content')
<div class="page-header"><h1>Panduan Kesehatan</h1><p class="page-header-typed" data-page-header-typed aria-live="off">Langkah praktis untuk mendukung kebiasaan hidup yang lebih sehat.</p></div>
<div class="breadcrumb"><div class="breadcrumb-inner"><a href="{{ route('home') }}">Beranda</a><span class="sep">›</span><a href="{{ route('layanan.index') }}">Layanan</a><span class="sep">›</span><span>Panduan Kesehatan</span></div></div>

<section class="section">
    <div class="section-inner">
        <nav aria-label="Kategori panduan" style="display:flex;justify-content:center;gap:.55rem;flex-wrap:wrap;margin-bottom:2rem">
            <a href="{{ route('panduan.index') }}" class="btn {{ $category === '' ? 'btn-primary' : 'btn-outline' }}">Semua</a>
            @foreach(['nutrisi' => 'Nutrisi', 'olahraga' => 'Olahraga', 'mental' => 'Mental', 'tidur' => 'Tidur', 'kebersihan' => 'Kebersihan', 'lainnya' => 'Lainnya'] as $key => $label)
                <a href="{{ route('panduan.index', ['category' => $key]) }}" class="btn {{ $category === $key ? 'btn-primary' : 'btn-outline' }}">{{ $label }}</a>
            @endforeach
        </nav>
        @if($guides->count())
            <div class="grid-3">
                @foreach($guides as $guide)
                    <a href="{{ route('panduan.show', $guide) }}" class="card" style="padding:1.4rem;display:flex;flex-direction:column;gap:.75rem">
                        <span style="width:2.75rem;height:2.75rem;border-radius:.8rem;background:var(--green-100);color:var(--green-700);display:flex;align-items:center;justify-content:center;font-size:1.1rem"><i class="{{ $guide->icon ?: 'fas fa-book-medical' }}"></i></span>
                        <span class="card-tag" style="align-self:flex-start">{{ ucfirst($guide->category) }}</span>
                        <h2 class="card-title" style="margin:0">{{ $guide->title }}</h2>
                        <p class="card-excerpt">{{ $guide->excerpt }}</p>
                        <span style="margin-top:auto;color:var(--green-700);font-size:.85rem;font-weight:700">Baca panduan <i class="fas fa-arrow-right"></i></span>
                    </a>
                @endforeach
            </div>
            <div class="pagination-wrap">{{ $guides->links('vendor.pagination.sehatin') }}</div>
        @else
            <div class="empty-state"><i class="fas fa-book-medical"></i><p>Belum ada panduan pada kategori ini.</p></div>
        @endif
    </div>
</section>
@endsection
