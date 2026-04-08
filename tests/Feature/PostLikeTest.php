<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows authenticated verified user to like and unlike a post', function () {
    $author = User::factory()->create(['email_verified_at' => now()]);
    $user = User::factory()->create(['email_verified_at' => now()]);

    $post = Post::create([
        'title' => 'Liked post',
        'slug' => 'liked-post',
        'content' => 'Content',
        'author' => $author->name,
        'user_id' => $author->id,
        'is_published' => true,
    ]);

    $likeResponse = $this->actingAs($user)->post(route('posts.like', $post));

    $likeResponse->assertRedirect();
    $this->assertDatabaseHas('post_likes', [
        'post_id' => $post->id,
        'user_id' => $user->id,
    ]);

    $unlikeResponse = $this->actingAs($user)->post(route('posts.like', $post));

    $unlikeResponse->assertRedirect();
    $this->assertDatabaseMissing('post_likes', [
        'post_id' => $post->id,
        'user_id' => $user->id,
    ]);
});
