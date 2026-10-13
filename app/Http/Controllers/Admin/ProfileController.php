<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index', ['user' => auth()->user()]);
    }

    public function edit()
    {
        return view('admin.profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^\\S+(?:\\s+\\S+)?$/u'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], ['name.regex' => __('app.name_two_words_hint')]);

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
                return redirect()->route('admin.profile.index')
                    ->with('error', 'Profil admin diperbarui, tetapi avatar lama gagal dihapus.');
            }
        }

        return redirect()->route('admin.profile.index')->with('success', 'Profil admin berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        if (!$user->password || !Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('admin.profile.edit')->with('success', 'Password admin berhasil diperbarui.');
    }
}
