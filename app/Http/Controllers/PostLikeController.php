<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class PostLikeController extends Controller
{
    public function toggle(Post $post): RedirectResponse
    {
        $alreadyLiked = $post->likedByUsers()
            ->where('users.id', auth()->id())
            ->exists();

        if ($alreadyLiked) {
            $post->likedByUsers()->detach(auth()->id());

            return back()->with('success', 'Usunieto polubienie posta.');
        }

        $post->likedByUsers()->syncWithoutDetaching([auth()->id()]);

        return back()->with('success', 'Polubiono post.');
    }
}
