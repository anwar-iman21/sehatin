@extends('layouts.app')

@section('title', __('auth.register'))

@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:2rem 1.25rem;background:var(--slate-50)">
    <div style="width:100%;max-width:420px">
        <div style="text-align:center;margin-bottom:2rem">
            <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:.5rem;font-weight:700;font-size:1.5rem;color:var(--green-700);text-decoration:none">
                <i class="fas fa-leaf"></i> <span>SEHAT<span style="color:var(--slate-800)">IN</span></span>
            </a>
            <h1 style="margin-top:1rem;font-size:1.35rem;font-weight:700;color:var(--slate-800)">{{ __('auth.create_account') }}</h1>
            <p style="color:var(--slate-500);font-size:.9rem;margin-top:.35rem">{{ __('auth.register_subtitle') }}</p>
        </div>

        <div style="background:var(--white);border:1px solid var(--slate-200);border-radius:var(--radius);padding:2rem;box-shadow:var(--shadow-sm)">

            {{-- Google --}}
            <a href="{{ route('auth.google') }}"
               style="display:flex;align-items:center;justify-content:center;gap:.75rem;width:100%;padding:.7rem 1rem;border:1.5px solid var(--slate-200);border-radius:.6rem;font-weight:600;font-size:.9rem;color:var(--slate-700);background:var(--white);transition:all .15s;text-decoration:none;margin-bottom:1.25rem"
               onmouseover="this.style.background='var(--slate-50)'"
               onmouseout="this.style.background='var(--white)'">
                <svg width="18" height="18" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
                {{ __('auth.login_with_google') }}
            </a>

            <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.25rem">
                <div style="flex:1;height:1px;background:var(--slate-200)"></div>
                <span style="font-size:.8rem;color:var(--slate-400)">{{ __('auth.or') }}</span>
                <div style="flex:1;height:1px;background:var(--slate-200)"></div>
            </div>

            @if(session('registration_session_expired'))
                <div class="alert alert-error" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('registration_session_expired') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ __('auth.validation.summary') }}</span>
                </div>
            @endif

            <form id="register-form" method="POST" action="{{ route('register') }}" data-session-url="{{ route('register.session') }}">
                @csrf

                @php
                    $inputStyle = "width:100%;padding:.65rem .9rem;border:1.5px solid var(--slate-200);border-radius:.55rem;font-size:.9rem;outline:none;font-family:inherit";
                    $labelStyle = "display:block;font-size:.875rem;font-weight:600;color:var(--slate-700);margin-bottom:.4rem";
                @endphp

                <div style="margin-bottom:1rem">
                    <label for="name" style="{{ $labelStyle }}">{{ __('auth.name') }}</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                        style="{{ $errors->has('name') ? $inputStyle . ';border-color:#dc2626' : $inputStyle }}" placeholder="Nama lengkap Anda"
                        aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                        onfocus="this.style.borderColor='var(--green-500)'"
                        onblur="this.style.borderColor='var(--slate-200)'">
                    @error('name')
                        <p id="name-error" role="alert" style="margin:.35rem 0 0;color:#dc2626;font-size:.8rem">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom:1rem">
                    <label for="email" style="{{ $labelStyle }}">{{ __('auth.email') }}</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        style="{{ $errors->has('email') ? $inputStyle . ';border-color:#dc2626' : $inputStyle }}" placeholder="nama@email.com"
                        aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                        onfocus="this.style.borderColor='var(--green-500)'"
                        onblur="this.style.borderColor='var(--slate-200)'">
                    @error('email')
                        <p id="email-error" role="alert" style="margin:.35rem 0 0;color:#dc2626;font-size:.8rem">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom:1rem">
                    <label for="password" style="{{ $labelStyle }}">{{ __('auth.password') }}</label>
                    <input id="password" type="password" name="password" required
                        style="{{ $errors->has('password') ? $inputStyle . ';border-color:#dc2626' : $inputStyle }}" placeholder="Min. 8 karakter"
                        aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                        onfocus="this.style.borderColor='var(--green-500)'"
                        onblur="this.style.borderColor='var(--slate-200)'">
                    @error('password')
                        <p id="password-error" role="alert" style="margin:.35rem 0 0;color:#dc2626;font-size:.8rem">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom:1.5rem">
                    <label for="password_confirmation" style="{{ $labelStyle }}">{{ __('auth.confirm_password') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        style="{{ $errors->has('password_confirmation') ? $inputStyle . ';border-color:#dc2626' : $inputStyle }}" placeholder="Ulangi kata sandi"
                        aria-invalid="{{ $errors->has('password_confirmation') ? 'true' : 'false' }}"
                        onfocus="this.style.borderColor='var(--green-500)'"
                        onblur="this.style.borderColor='var(--slate-200)'">
                    @error('password_confirmation')
                        <p id="password-confirmation-error" role="alert" style="margin:.35rem 0 0;color:#dc2626;font-size:.8rem">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;padding:.75rem">
                    {{ __('auth.register') }}
                </button>
            </form>
            <p id="register-session-error" role="alert" hidden style="margin:.75rem 0 0;color:#dc2626;font-size:.85rem">
                {{ __('auth.session_refresh_failed') }}
            </p>

            <p style="text-align:center;margin-top:1.25rem;font-size:.875rem;color:var(--slate-500)">
                {{ __('auth.have_account') }}
                <a href="{{ route('login') }}" style="color:var(--green-700);font-weight:600">{{ __('auth.login_link') }}</a>
            </p>
        </div>
    </div>
</div>

<script>
    (() => {
        const form = document.getElementById('register-form');
        const tokenInput = form?.querySelector('input[name="_token"]');
        const errorMessage = document.getElementById('register-session-error');
        let refreshRequest = null;

        if (!form || !tokenInput || !errorMessage) {
            return;
        }

        const refreshToken = () => {
            if (refreshRequest) {
                return refreshRequest;
            }

            refreshRequest = fetch(form.dataset.sessionUrl, {
                credentials: 'same-origin',
                cache: 'no-store',
                headers: { Accept: 'application/json' },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`Session refresh failed with status ${response.status}.`);
                    }

                    return response.json();
                })
                .then((data) => {
                    if (typeof data.token !== 'string' || data.token.length === 0) {
                        throw new Error('Session refresh returned no CSRF token.');
                    }

                    tokenInput.value = data.token;
                    errorMessage.hidden = true;

                    return true;
                })
                .catch((error) => {
                    console.error('Unable to refresh registration session.', error);
                    errorMessage.hidden = false;

                    return false;
                })
                .finally(() => {
                    refreshRequest = null;
                });

            return refreshRequest;
        };

        window.setInterval(refreshToken, 10 * 60 * 1000);
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') {
                refreshToken();
            }
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;

            if (await refreshToken()) {
                HTMLFormElement.prototype.submit.call(form);
                return;
            }

            submitButton.disabled = false;
        });
    })();
</script>
@endsection
