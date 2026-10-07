@extends('admin.layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="form-card" style="max-width:800px">
    <div style="display:flex;align-items:center;gap:1.25rem;margin-bottom:1.5rem">
        @if($user->avatar)
            <img
                src="{{ \Illuminate\Support\Str::startsWith($user->avatar, ['http://', 'https://']) ? $user->avatar : asset('storage/'.$user->avatar) }}"
                alt="Avatar {{ $user->name }}"
                width="96"
                height="96"
                style="object-fit:cover;border-radius:50%"
            >
        @endif
        <div>
            <h2 style="font-size:1.15rem;font-weight:700">{{ $user->name }}</h2>
            <p style="color:var(--slate-500);font-size:.875rem">{{ $user->email }}</p>
        </div>
    </div>
    <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary"><i class="fas fa-pen"></i> Edit Profil</a>
</div>
@endsection
