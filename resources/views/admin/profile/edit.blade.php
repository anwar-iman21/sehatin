@extends('admin.layouts.app')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')

@section('content')
@if($errors->any())
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0;padding-left:1rem">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="form-card" style="max-width:800px">
    <h2 style="font-size:1rem;font-weight:700;margin-bottom:.35rem">Informasi Profil</h2>
    <p style="font-size:.85rem;color:var(--slate-500);margin-bottom:1.25rem">Perbarui nama dan foto yang digunakan pada akun admin.</p>
    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="form-label" for="name">Nama</label>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" maxlength="255" pattern="\S+(?:\s+\S+)?" title="{{ __('app.name_two_words_hint') }}" required>
            <p class="form-hint">{{ __('app.name_two_words_hint') }}</p>
        </div>
        <div class="form-group">
            <label class="form-label" for="avatar">Avatar</label>
            <input id="avatar" type="file" name="avatar" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
            <p class="form-hint">Format JPG, JPEG, PNG, atau WEBP; maksimal 2 MB.</p>
        </div>
        <div class="form-actions">
            <a href="{{ route('admin.profile.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Profil</button>
        </div>
    </form>
</div>

<div class="form-card" style="max-width:800px;margin-top:1.5rem">
    <h2 style="font-size:1rem;font-weight:700;margin-bottom:.35rem">Ganti Password</h2>
    <p style="font-size:.85rem;color:var(--slate-500);margin-bottom:1.25rem">Masukkan password lama untuk mengatur password baru.</p>
    <form action="{{ route('admin.profile.password') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label class="form-label" for="current_password">Password Lama</label>
            <input id="current_password" type="password" name="current_password" class="form-control" autocomplete="current-password" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="password">Password Baru</label>
            <input id="password" type="password" name="password" class="form-control" minlength="8" autocomplete="new-password" required>
        </div>
        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" minlength="8" autocomplete="new-password" required>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary"><i class="fas fa-key"></i> Ganti Password</button>
        </div>
    </form>
</div>
@endsection
