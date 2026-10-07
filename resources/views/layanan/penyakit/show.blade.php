@extends('layouts.app')

@section('title', $disease->name . ' — Info Penyakit')

@section('content')
<div class="page-header"><h1>{{ $disease->name }}</h1><p class="page-header-typed" data-page-header-typed aria-live="off">Informasi umum dan edukasi kesehatan</p></div>
<div class="breadcrumb"><div class="breadcrumb-inner"><a href="{{ route('home') }}">Beranda</a><span class="sep">›</span><a href="{{ route('layanan.index') }}">Layanan</a><span class="sep">›</span><a href="{{ route('penyakit.index') }}">Info Penyakit</a><span class="sep">›</span><span>{{ $disease->name }}</span></div></div>

<section class="section">
    <div class="section-inner" style="max-width:900px">
        <div class="card" style="padding:clamp(1.25rem,4vw,2.5rem)">
            @if($disease->category)<span class="card-tag" style="display:inline-flex;margin-bottom:1rem">{{ str_replace('-', ' ', ucfirst($disease->category)) }}</span>@endif
            <p style="font-size:1rem;line-height:1.8;color:var(--slate-600);margin-bottom:1.25rem">{{ $disease->overview }}</p>
            <div style="display:grid;gap:1rem">
                @foreach([
                    'Gejala' => $disease->symptoms,
                    'Penyebab' => $disease->causes,
                    'Faktor risiko' => $disease->risk_factors,
                    'Diagnosis' => $disease->diagnosis,
                    'Pengobatan' => $disease->treatment,
                    'Pencegahan' => $disease->prevention,
                    'Kapan harus ke dokter' => $disease->when_to_see_doctor,
                ] as $label => $value)
                    @if($value)
                        <div style="padding:1rem 1.15rem;border-left:3px solid var(--green-500);background:var(--slate-50);border-radius:0 .65rem .65rem 0">
                            <h2 style="font-size:.95rem;color:var(--slate-800);margin-bottom:.4rem">{{ $label }}</h2>
                            <p style="font-size:.9rem;color:var(--slate-600);line-height:1.75;white-space:pre-line">{{ $value }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="disclaimer-box" style="margin-top:1.25rem"><i class="fas fa-triangle-exclamation"></i> Informasi ini bersifat edukatif dan tidak menggantikan konsultasi dengan tenaga kesehatan profesional.</div>
        <a href="{{ route('penyakit.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali ke Info Penyakit</a>
    </div>
</section>
@endsection
