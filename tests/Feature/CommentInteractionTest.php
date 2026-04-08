<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows verified user to reply to a comment', function () {
    $author = User::factory()->create(['email_verified_at' => now()]);
    $user = User::factory()->create(['email_verified_at' => now()]);

    $post = Post::create([
        'title' => 'Reply target post',
        'slug' => 'reply-target-post',
        'content' => 'Post content',
        'author' => $author->name,
        'user_id' => $author->id,
        'is_published' => true,
    ]);

    $comment = Comment::create([
        'post_id' => $post->id,
        'user_id' => $author->id,
        'author' => $author->name,
        'email' => $author->email,
        'content' => 'Original comment',
        'is_approved' => true,
    ]);

    $response = $this->actingAs($author)->post(route('comments.reply', $comment), [
        'content' => 'Reply content',
    ]);

    $response->assertRedirect(route('posts.show', $post->slug));

    $this->assertDatabaseHas('comments', [
        'post_id' => $post->id,
        'parent_id' => $comment->id,
        'content' => 'Reply content',
    ]);
});

it('allows user to like and unlike own approved comment', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);

    $post = Post::create([
        'title' => 'Like target post',
        'slug' => 'like-target-post',
        'content' => 'Post content',
        'author' => $user->name,
        'user_id' => $user->id,
        'is_published' => true,
    ]);

    $comment = Comment::create([
        'post_id' => $post->id,
        'user_id' => $user->id,
        'author' => $user->name,
        'email' => $user->email,
        'content' => 'Self comment',
        'is_approved' => true,
        'likes_count' => 0,
    ]);

    $likeResponse = $this->actingAs($user)->post(route('comments.like', $comment));

    $likeResponse->assertRedirect();
    $this->assertDatabaseHas('comment_likes', [
        'comment_id' => $comment->id,
        'user_id' => $user->id,
    ]);
    expect($comment->fresh()->likes_count)->toBe(1);

    $unlikeResponse = $this->actingAs($user)->post(route('comments.like', $comment));

    $unlikeResponse->assertRedirect();
    $this->assertDatabaseMissing('comment_likes', [
        'comment_id' => $comment->id,
        'user_id' => $user->id,
    ]);
    expect($comment->fresh()->likes_count)->toBe(0);
});
