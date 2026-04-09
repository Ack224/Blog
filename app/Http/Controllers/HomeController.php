<?php

namespace App\Http\Controllers;

use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $weeklyTopPosts = Post::query()
            ->with(['user', 'tags'])
            ->withCount(['likedByUsers', 'bookmarkedBy'])
            ->withCount([
                'likedByUsers as weekly_likes_count' => function ($query): void {
                    $query->where('post_likes.created_at', '>=', now()->subDays(7));
                },
            ])
            ->published()
            ->orderByDesc('weekly_likes_count')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('home', [
            'weeklyTopPosts' => $weeklyTopPosts,
        ]);
    }
}
