@extends('layouts.app')

@section('title', 'Info Obat')

@section('content')
<div class="page-header">
    <h1>Info Obat</h1>
    <p class="page-header-typed" data-page-header-typed aria-live="off">Informasi edukatif tentang penggunaan obat dengan bijak.</p>
</div>
<div class="breadcrumb"><div class="breadcrumb-inner"><a href="{{ route('home') }}">Beranda</a><span class="sep">›</span><a href="{{ route('layanan.index') }}">Layanan</a><span class="sep">›</span><span>Info Obat</span></div></div>

<section class="section">
    <div class="section-inner">
        <form method="GET" action="{{ route('obat.index') }}" style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:1.25rem">
            <label for="drug-search" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0">Cari nama obat</label>
            <input id="drug-search" type="search" name="q" value="{{ $search }}" placeholder="Cari nama obat..." style="flex:1;min-width:220px;padding:.75rem 1rem;border:1px solid var(--slate-200);border-radius:.6rem;font:inherit">
            <select name="category" aria-label="Kategori obat" style="min-width:190px;padding:.75rem 1rem;border:1px solid var(--slate-200);border-radius:.6rem;background:white;color:var(--slate-700);font:inherit">
                <option value="">Semua kategori</option>
                <option value="resep" @selected($category === 'resep')>Obat resep</option>
                <option value="bebas" @selected($category === 'bebas')>Obat bebas</option>
                <option value="bebas_terbatas" @selected($category === 'bebas_terbatas')>Bebas terbatas</option>
            </select>
            @if($letter)<input type="hidden" name="letter" value="{{ $letter }}">@endif
            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Cari</button>
            @if($search || $category || $letter)<a class="btn btn-outline" href="{{ route('obat.index') }}">Reset</a>@endif
        </form>

        <div style="display:flex;align-items:center;gap:.4rem;flex-wrap:wrap;margin-bottom:1.5rem" aria-label="Filter huruf nama obat">
            <a href="{{ route('obat.index', array_filter(['q' => $search, 'category' => $category])) }}" class="btn btn-sm {{ $letter === '' ? 'btn-primary' : 'btn-outline' }}">Semua</a>
            @foreach(range('A', 'Z') as $alphabet)
                <a href="{{ route('obat.index', array_filter(['q' => $search, 'category' => $category, 'letter' => $alphabet])) }}" class="btn btn-sm {{ $letter === $alphabet ? 'btn-primary' : 'btn-outline' }}">{{ $alphabet }}</a>
            @endforeach
        </div>

        @if($drugs->count())
            <div class="grid-3">
                @foreach($drugs as $drug)
                    <a href="{{ route('obat.show', $drug) }}" class="card" style="padding:1.35rem;display:flex;flex-direction:column;gap:.65rem">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:.75rem">
                            <h2 class="card-title" style="margin:0">{{ $drug->name }}</h2>
                            <span class="card-tag">{{ str_replace('_', ' ', ucfirst($drug->category)) }}</span>
                        </div>
                        @if($drug->generic_name)<p style="font-size:.85rem;color:var(--slate-500)">Generik: {{ $drug->generic_name }}</p>@endif
                        <p style="font-size:.8rem;color:var(--slate-400);margin-top:auto"><i class="fas fa-capsules"></i> {{ ucfirst($drug->form) }}</p>
                    </a>
                @endforeach
            </div>
            <div class="pagination-wrap">{{ $drugs->links('vendor.pagination.sehatin') }}</div>
        @else
            <div class="empty-state"><i class="fas fa-pills"></i><p>Tidak ada informasi obat yang cocok dengan pencarian.</p></div>
        @endif
    </div>
</section>
@endsection
