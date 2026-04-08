<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function show(User $user): View
    {
        $posts = $user->posts()
            ->where('is_published', true)
            ->withCount(['likedByUsers', 'bookmarkedBy'])
            ->latest()
            ->paginate(9);

        $followersCount = $user->followers()->count();
        $followingCount = $user->following()->count();

        $isFollowing = auth()->check()
            ? auth()->user()->following()->where('users.id', $user->id)->exists()
            : false;

        return view('users.show', [
            'profileUser' => $user,
            'posts' => $posts,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'isFollowing' => $isFollowing,
        ]);
    }

    public function follow(Request $request, User $user): RedirectResponse
    {
        $this->authorize('follow-user', $user);

        if ($request->user()->id === $user->id) {
            return back()->with('error', 'Nie mozesz obserwowac samego siebie.');
        }

        $request->user()->following()->syncWithoutDetaching([$user->id]);

        return back()->with('success', 'Zacząłeś obserwować autora.');
    }

    public function unfollow(Request $request, User $user): RedirectResponse
    {
        if ($request->user()->id === $user->id) {
            return back()->with('error', 'Nie mozesz wykonac tej operacji.');
        }

        $request->user()->following()->detach($user->id);

        return back()->with('success', 'Przestałeś obserwować autora.');
    }

    public function edit(Request $request): View
    {
        return view('users.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'x_url' => ['nullable', 'url', 'max:255'],
            'locale' => ['required', 'in:pl,en'],
            'theme' => ['required', 'in:light,dark'],
        ]);

        $request->user()->update($validated);

        return redirect()->route('users.show', $request->user())->with('success', 'Profil zostal zaktualizowany.');
    }

    public function switchLocale(Request $request, string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, ['pl', 'en'], true), 404);

        $request->session()->put('locale', $locale);

        if ($request->user()) {
            $request->user()->update(['locale' => $locale]);
        }

        return back();
    }
}
