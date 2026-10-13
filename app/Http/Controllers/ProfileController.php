<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $bookmarkedArticles = $user->bookmarkedArticles()->with(['category', 'user'])
            ->latest('article_bookmarks.created_at')->paginate(8, ['articles.*'], 'saved_page');
        $searchHistories = $user->searchHistories()->latest('updated_at')->limit(20)->get();

        return view('profile.index', compact('user', 'bookmarkedArticles', 'searchHistories'));
    }

    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
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
                return back()->withErrors(['avatar' => __('app.avatar_store_failed')])->withInput();
            }

            $validated['avatar'] = $avatarPath;
        }

        $user->update($validated);

        if (isset($validated['avatar']) && $oldAvatar && str_starts_with($oldAvatar, 'avatars/')) {
            $disk = Storage::disk('public');
            if ($disk->exists($oldAvatar) && !$disk->delete($oldAvatar)) {
                return redirect()->route('profile.index')
                    ->with('error', __('app.avatar_delete_failed'));
            }
        }

        return redirect()->route('profile.index')->with('success', __('app.profile_updated'));
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        if ($user->google_id !== null) {
            return redirect()->route('profile.edit')
                ->with('error', __('app.google_password_change_unavailable'));
        }

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!$user->password || !Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => __('app.current_password_invalid')]);
        }

        $user->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('profile.edit')->with('success', __('app.password_updated'));
    }
}
