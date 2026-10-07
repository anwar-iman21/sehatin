@extends('layouts.app')

@section('content')
<section class="section">
    <div class="section-inner" style="max-width:900px">
        <div class="section-header">
            <div>
                <h1 class="section-title">Edit Profil</h1>
                <p style="margin-top:.35rem;color:var(--slate-500);font-size:.9rem">Perbarui informasi akun dan pengaturan keamanan Anda.</p>
            </div>
            <a href="{{ route('profile.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin:0;padding-left:1rem">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="card" style="margin-bottom:1.5rem">
            <div class="card-body">
                <h2 class="card-title" style="margin-bottom:.35rem">Informasi Profil</h2>
                <p class="card-excerpt" style="margin-bottom:1.5rem">Nama dan foto ini akan digunakan pada akun Anda.</p>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div style="margin-bottom:1.25rem">
                        <label for="name" style="display:block;margin-bottom:.4rem;font-size:.875rem;font-weight:600;color:var(--slate-700)">Nama</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" maxlength="255" required autocomplete="name" style="display:block;width:100%;padding:.7rem .85rem;border:1px solid var(--slate-200);border-radius:.55rem;background:var(--white);color:var(--slate-800);font:inherit">
                    </div>
                    <div style="margin-bottom:1.5rem">
                        <label for="avatar" style="display:block;margin-bottom:.4rem;font-size:.875rem;font-weight:600;color:var(--slate-700)">Foto Profil</label>
                        @if($user->avatar)
                            <img
                                src="{{ \Illuminate\Support\Str::startsWith($user->avatar, ['http://', 'https://']) ? $user->avatar : asset('storage/'.$user->avatar) }}"
                                alt="Foto profil saat ini"
                                width="72"
                                height="72"
                                style="object-fit:cover;border-radius:50%;margin-bottom:.75rem"
                            >
                        @endif
                        <input id="avatar" type="file" name="avatar" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" style="display:block;width:100%;padding:.65rem;border:1px solid var(--slate-200);border-radius:.55rem;background:var(--slate-50);color:var(--slate-600);font:inherit">
                        <p style="margin-top:.45rem;color:var(--slate-500);font-size:.8rem">JPG, JPEG, PNG, atau WEBP. Ukuran maksimal 2 MB.</p>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Profil</button>
                </form>
            </div>
        </div>

        @if($user->google_id === null)
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title" style="margin-bottom:.35rem">Ganti Password</h2>
                    <p class="card-excerpt" style="margin-bottom:1.5rem">Gunakan password yang kuat dan belum pernah digunakan sebelumnya.</p>
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div style="margin-bottom:1.25rem">
                            <label for="current_password" style="display:block;margin-bottom:.4rem;font-size:.875rem;font-weight:600;color:var(--slate-700)">Password Lama</label>
                            <input id="current_password" type="password" name="current_password" autocomplete="current-password" required style="display:block;width:100%;padding:.7rem .85rem;border:1px solid var(--slate-200);border-radius:.55rem;background:var(--white);color:var(--slate-800);font:inherit">
                        </div>
                        <div style="margin-bottom:1.25rem">
                            <label for="password" style="display:block;margin-bottom:.4rem;font-size:.875rem;font-weight:600;color:var(--slate-700)">Password Baru</label>
                            <input id="password" type="password" name="password" minlength="8" autocomplete="new-password" required style="display:block;width:100%;padding:.7rem .85rem;border:1px solid var(--slate-200);border-radius:.55rem;background:var(--white);color:var(--slate-800);font:inherit">
                            <p style="margin-top:.4rem;color:var(--slate-500);font-size:.8rem">Minimal 8 karakter.</p>
                        </div>
                        <div style="margin-bottom:1.5rem">
                            <label for="password_confirmation" style="display:block;margin-bottom:.4rem;font-size:.875rem;font-weight:600;color:var(--slate-700)">Konfirmasi Password Baru</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" minlength="8" autocomplete="new-password" required style="display:block;width:100%;padding:.7rem .85rem;border:1px solid var(--slate-200);border-radius:.55rem;background:var(--white);color:var(--slate-800);font:inherit">
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-key"></i> Perbarui Password</button>
                    </form>
                </div>
            </div>
        @else
            <div class="disclaimer-box">
                <i class="fas fa-info-circle"></i>
                Password dikelola melalui akun Google Anda, sehingga tidak dapat diubah di sini.
            </div>
        @endif
    </div>
</section>
@endsection
