@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-inner">
        <div class="section-header">
            <h1 class="section-title">Profil Saya</h1>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary"><i class="fas fa-pen"></i> Edit Profil</a>
        </div>

        <div class="card">
            <div class="card-body">
                @if($user->avatar)
                    <img
                        src="{{ \Illuminate\Support\Str::startsWith($user->avatar, ['http://', 'https://']) ? $user->avatar : asset('storage/'.$user->avatar) }}"
                        alt="Avatar {{ $user->name }}"
                        width="120"
                        height="120"
                        style="object-fit:cover;border-radius:50%;margin-bottom:1rem"
                    >
                @endif
                <h2 class="card-title">{{ $user->name }}</h2>
                <p class="card-excerpt">{{ $user->email }}</p>
            </div>
        </div>
    </div>
</section>
@endsection
