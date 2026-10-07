<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return Auth::user()->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('home');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return Auth::user()->isAdmin()
                ? redirect()->intended(route('admin.dashboard'))
                : redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => __('auth.failed'),
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function refreshRegisterSession()
    {
        return response()
            ->json(['token' => csrf_token()])
            ->header('Cache-Control', 'no-store, private');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'password_confirmation' => ['required', 'same:password'],
        ], [
            'name.required' => __('auth.validation.name_required'),
            'name.string' => __('auth.validation.name_string'),
            'name.max' => __('auth.validation.name_max'),
            'email.required' => __('auth.validation.email_required'),
            'email.string' => __('auth.validation.email_string'),
            'email.email' => __('auth.validation.email_invalid'),
            'email.max' => __('auth.validation.email_max'),
            'email.unique' => __('auth.validation.email_unique'),
            'password.required' => __('auth.validation.password_required'),
            'password.min' => __('auth.validation.password_min'),
            'password_confirmation.required' => __('auth.validation.password_confirmation_required'),
            'password_confirmation.same' => __('auth.validation.password_confirmation_same'),
        ], [
            'name' => __('auth.name'),
            'email' => __('auth.email'),
            'password' => __('auth.password'),
            'password_confirmation' => __('auth.confirm_password'),
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
