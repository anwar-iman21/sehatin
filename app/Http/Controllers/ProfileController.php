<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index', ['user' => auth()->user()]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user = $request->user();
        $oldAvatar = $user->avatar;

        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');

            if ($avatarPath === false) {
                return back()->withErrors(['avatar' => 'Avatar gagal disimpan. Silakan coba lagi.'])->withInput();
            }

            $validated['avatar'] = $avatarPath;
        }

        $user->update($validated);

        if (isset($validated['avatar']) && $oldAvatar && str_starts_with($oldAvatar, 'avatars/')) {
            $disk = Storage::disk('public');
            if ($disk->exists($oldAvatar) && !$disk->delete($oldAvatar)) {
                return redirect()->route('profile.index')
                    ->with('error', 'Profil diperbarui, tetapi avatar lama gagal dihapus.');
            }
        }

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        if ($user->google_id !== null) {
            return redirect()->route('profile.edit')
                ->with('error', 'Akun Google tidak dapat mengganti password di sini.');
        }

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!$user->password || !Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('profile.edit')->with('success', 'Password berhasil diperbarui.');
    }
}
