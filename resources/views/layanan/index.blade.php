@extends('layouts.app')

@section('title', 'Layanan Informasi Kesehatan')

@section('content')
<div class="page-header">
    <h1>Layanan Informasi Kesehatan</h1>
    <p class="page-header-typed" data-page-header-typed aria-live="off">Temukan informasi obat, penyakit, dan panduan kesehatan yang tepercaya.</p>
</div>

<div class="breadcrumb">
    <div class="breadcrumb-inner">
        <a href="{{ route('home') }}">{{ __('app.breadcrumb_home') }}</a>
        <span class="sep">›</span>
        <span>Layanan Kesehatan</span>
    </div>
</div>

<section class="section">
    <div class="section-inner">
        <div class="grid-3">
            <a href="{{ route('obat.index') }}" class="card" style="padding:1.75rem;display:flex;flex-direction:column;gap:.85rem">
                <span style="width:3.25rem;height:3.25rem;display:flex;align-items:center;justify-content:center;border-radius:1rem;background:var(--green-100);color:var(--green-700);font-size:1.35rem"><i class="fas fa-pills"></i></span>
                <h2 class="card-title">Info Obat</h2>
                <p class="card-excerpt">Cari kegunaan, cara penggunaan, efek samping, dan informasi penting obat.</p>
                <span style="margin-top:auto;color:var(--green-700);font-weight:700">Jelajahi obat <i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="{{ route('penyakit.index') }}" class="card" style="padding:1.75rem;display:flex;flex-direction:column;gap:.85rem">
                <span style="width:3.25rem;height:3.25rem;display:flex;align-items:center;justify-content:center;border-radius:1rem;background:#dbeafe;color:#2563eb;font-size:1.35rem"><i class="fas fa-virus"></i></span>
                <h2 class="card-title">Info Penyakit</h2>
                <p class="card-excerpt">Pelajari gejala, faktor risiko, pemeriksaan, dan langkah pencegahan.</p>
                <span style="margin-top:auto;color:var(--green-700);font-weight:700">Jelajahi penyakit <i class="fas fa-arrow-right"></i></span>
            </a>
            <a href="{{ route('panduan.index') }}" class="card" style="padding:1.75rem;display:flex;flex-direction:column;gap:.85rem">
                <span style="width:3.25rem;height:3.25rem;display:flex;align-items:center;justify-content:center;border-radius:1rem;background:#fef3c7;color:#b45309;font-size:1.35rem"><i class="fas fa-book-medical"></i></span>
                <h2 class="card-title">Panduan Kesehatan</h2>
                <p class="card-excerpt">Temukan panduan praktis untuk mendukung kebiasaan hidup sehat.</p>
                <span style="margin-top:auto;color:var(--green-700);font-weight:700">Baca panduan <i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</section>

@if($services->isNotEmpty())
    <section class="section section-alt">
        <div class="section-inner">
            <div class="section-header">
                <h2 class="section-title">Layanan Lainnya</h2>
            </div>
            <div class="grid-3">
                @foreach($services as $service)
                    <a href="{{ route('layanan.detail', $service) }}" class="card">
                        <div class="card-body">
                            <i class="{{ $service->icon ?? 'fas fa-stethoscope' }}" style="display:block;margin-bottom:.75rem;color:var(--green-600);font-size:1.75rem"></i>
                            <h3 class="card-title">{{ $service->name }}</h3>
                            <p class="card-excerpt">{{ $service->description }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
@endsection
