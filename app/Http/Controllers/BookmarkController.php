<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookmarkController extends Controller
{
    public function index(Request $request): View
    {
        $bookmarks = $request->user()
            ->bookmarks()
            ->with('user')
            ->withCount(['likedByUsers', 'bookmarkedBy'])
            ->latest('bookmarks.created_at')
            ->paginate(9);

        return view('bookmarks.index', [
            'bookmarks' => $bookmarks,
        ]);
    }

    public function store(Request $request, Post $post)
    {
        $this->authorize('bookmark-post', $post);

        $request->user()->bookmarks()->syncWithoutDetaching([$post->id]);

        return back()->with('success', 'Post zapisany w zakladkach.');
    }

    public function destroy(Request $request, Post $post)
    {
        $request->user()->bookmarks()->detach($post->id);

        return back()->with('success', 'Post usuniety z zakladek.');
    }
}
