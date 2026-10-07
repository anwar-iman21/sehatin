@extends('layouts.app')

@section('title', '500 — Server Error')

@section('content')
<div style="min-height:70vh;display:flex;align-items:center;justify-content:center;padding:3rem 1.25rem;text-align:center">
    <div>
        <div style="font-size:6rem;font-weight:800;color:var(--green-200);line-height:1;margin-bottom:1rem;font-family:'Merriweather',serif">500</div>
        <div style="width:64px;height:64px;border-radius:50%;background:var(--green-100);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem">
            <i class="fas fa-tools" style="font-size:1.75rem;color:var(--green-600)"></i>
        </div>
        <h1 style="font-family:'Merriweather',serif;font-size:1.75rem;color:var(--slate-800);margin-bottom:.75rem">
            Terjadi Kesalahan Server
        </h1>
        <p style="color:var(--slate-500);font-size:1rem;max-width:400px;margin:0 auto 2rem">
            Maaf, terjadi kesalahan pada server kami. Tim kami sedang bekerja untuk memperbaikinya. Silakan coba kembali beberapa saat lagi.
        </p>
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="fas fa-home"></i> {{ __('app.back_to_home') }}
        </a>
    </div>
</div>
@endsection
