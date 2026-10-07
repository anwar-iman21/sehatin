@extends('layouts.app')

@section('title', $drug->name . ' — Info Obat')

@section('content')
<div class="page-header"><h1>{{ $drug->name }}</h1><p class="page-header-typed" data-page-header-typed aria-live="off">{{ $drug->generic_name ?: 'Informasi obat' }}</p></div>
<div class="breadcrumb"><div class="breadcrumb-inner"><a href="{{ route('home') }}">Beranda</a><span class="sep">›</span><a href="{{ route('layanan.index') }}">Layanan</a><span class="sep">›</span><a href="{{ route('obat.index') }}">Info Obat</a><span class="sep">›</span><span>{{ $drug->name }}</span></div></div>

<section class="section">
    <div class="section-inner" style="max-width:900px">
        <div class="card" style="padding:clamp(1.25rem,4vw,2.5rem)">
            <div style="display:flex;gap:.6rem;flex-wrap:wrap;margin-bottom:1.5rem">
                <span class="card-tag">{{ str_replace('_', ' ', ucfirst($drug->category)) }}</span>
                <span class="badge badge-gray">{{ ucfirst($drug->form) }}</span>
            </div>
            <p style="font-size:1rem;color:var(--slate-600);line-height:1.8;margin-bottom:1.5rem">{{ $drug->content }}</p>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,320px),1fr));gap:1.25rem">
                @foreach([
                    'Kandungan / nama generik' => $drug->generic_name,
                    'Produsen' => $drug->manufacturer,
                    'Indikasi' => $drug->indication,
                    'Dosis' => $drug->dosage,
                    'Cara penggunaan' => $drug->how_to_use,
                    'Efek samping' => $drug->side_effects,
                    'Kontraindikasi' => $drug->contraindication,
                    'Peringatan' => $drug->warning,
                    'Kisaran harga' => $drug->price_range,
                ] as $label => $value)
                    @if($value)
                        <div style="padding:1rem;background:var(--slate-50);border:1px solid var(--slate-100);border-radius:.65rem">
                            <h2 style="font-size:.9rem;color:var(--green-700);margin-bottom:.45rem">{{ $label }}</h2>
                            <p style="font-size:.875rem;color:var(--slate-600);line-height:1.75;white-space:pre-line">{{ $value }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="disclaimer-box" style="margin-top:1.25rem"><i class="fas fa-triangle-exclamation"></i> Informasi ini bersifat edukatif dan tidak menggantikan konsultasi dengan tenaga kesehatan profesional. Selalu ikuti kemasan obat dan petunjuk dokter atau apoteker.</div>
        <a href="{{ route('obat.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali ke Info Obat</a>
    </div>
</section>
@endsection
