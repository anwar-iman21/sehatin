@extends('layouts.app')

@section('title', 'Info Penyakit')

@section('content')
<div class="page-header"><h1>Info Penyakit</h1><p class="page-header-typed" data-page-header-typed aria-live="off">Kenali gejala dan pencegahan melalui informasi kesehatan yang edukatif.</p></div>
<div class="breadcrumb"><div class="breadcrumb-inner"><a href="{{ route('home') }}">Beranda</a><span class="sep">›</span><a href="{{ route('layanan.index') }}">Layanan</a><span class="sep">›</span><span>Info Penyakit</span></div></div>

<section class="section">
    <div class="section-inner">
        <form method="GET" action="{{ route('penyakit.index') }}" style="display:flex;gap:.75rem;max-width:760px;margin:0 auto 2rem">
            <label for="disease-search" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0">Cari penyakit</label>
            <input id="disease-search" type="search" name="q" value="{{ $search }}" placeholder="Cari nama penyakit..." style="flex:1;min-width:0;padding:.75rem 1rem;border:1px solid var(--slate-200);border-radius:.6rem;font:inherit">
            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
            @if($search)<a class="btn btn-outline" href="{{ route('penyakit.index') }}">Reset</a>@endif
        </form>
        @if($diseases->count())
            <div class="grid-3">
                @foreach($diseases as $disease)
                    <a href="{{ route('penyakit.show', $disease) }}" class="card" style="padding:1.4rem;display:flex;flex-direction:column;gap:.7rem">
                        <div style="display:flex;align-items:center;gap:.65rem">
                            <span style="width:2.5rem;height:2.5rem;border-radius:.75rem;background:#dbeafe;color:#2563eb;display:flex;align-items:center;justify-content:center"><i class="fas fa-heart-pulse"></i></span>
                            <h2 class="card-title" style="margin:0">{{ $disease->name }}</h2>
                        </div>
                        @if($disease->category)<span class="card-tag" style="align-self:flex-start">{{ str_replace('-', ' ', ucfirst($disease->category)) }}</span>@endif
                        <p class="card-excerpt">{{ $disease->overview }}</p>
                        <span style="margin-top:auto;color:var(--green-700);font-size:.85rem;font-weight:700">Baca selengkapnya <i class="fas fa-arrow-right"></i></span>
                    </a>
                @endforeach
            </div>
            <div class="pagination-wrap">{{ $diseases->links('vendor.pagination.sehatin') }}</div>
        @else
            <div class="empty-state"><i class="fas fa-heart-pulse"></i><p>Tidak ada informasi penyakit yang cocok dengan pencarian.</p></div>
        @endif
    </div>
</section>
@endsection
