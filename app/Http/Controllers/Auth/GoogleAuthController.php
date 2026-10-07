<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($user) {
                // Update google_id if logged in via email before
                if (! $user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            } else {
                // Create new user — always as 'user' role, never admin
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => null,
                    'role' => 'user',
                ]);
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            return $user->isAdmin()
                ? redirect()->route('admin.dashboard')
                : redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => __('auth.google_failed')]);
        }
    }
}
