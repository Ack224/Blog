<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define authorization gates
        Gate::define('create-post', function (User $user) {
            return true; // All authenticated users can create posts
        });

        Gate::define('update-post', function (User $user, Post $post) {
            return $user->id === $post->user_id;
        });

        Gate::define('delete-post', function (User $user, Post $post) {
            return $user->id === $post->user_id;
        });

        Gate::define('bookmark-post', function (User $user, Post $post) {
            return true; // All authenticated users can bookmark
        });

        Gate::define('follow-user', function (User $user, User $targetUser) {
            return $user->id !== $targetUser->id;
        });
    }
}
