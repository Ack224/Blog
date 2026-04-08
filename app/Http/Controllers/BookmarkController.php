<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function toggle(Post $post)
    {
        $user = Auth::user();

        $exists = $user->bookmarks()->where('post_id', $post->id)->exists();

        if ($exists) {
            $user->bookmarks()->where('post_id', $post->id)->delete();
            $message = 'Post został usunięty z zakładek!';
        } else {
            $user->bookmarks()->create(['post_id' => $post->id]);
            $message = 'Post został dodany do zakładek!';
        }

        return back()->with('success', $message);
    }
}

