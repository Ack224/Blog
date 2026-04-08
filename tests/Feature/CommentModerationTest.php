<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('stores non-author comments as pending moderation', function () {
    $author = User::factory()->create(['email_verified_at' => now()]);
    $commenter = User::factory()->create(['email_verified_at' => now()]);

    $post = Post::create([
        'title' => 'Moderation Post',
        'slug' => 'moderation-post',
        'lead' => 'Moderation lead',
        'content' => 'Moderation content',
        'author' => $author->name,
        'is_published' => true,
        'user_id' => $author->id,
    ]);

    $response = $this->actingAs($commenter)
        ->post(route('comments.store', $post->id), [
            'content' => 'This comment needs approval',
        ]);

    $response->assertRedirect(route('posts.show', $post->slug));
    $response->assertSessionHas('success', 'Komentarz oczekuje na moderacje.');

    $this->assertDatabaseHas('comments', [
        'post_id' => $post->id,
        'user_id' => $commenter->id,
        'content' => 'This comment needs approval',
        'is_approved' => false,
    ]);
});

it('auto-approves comments written by the post author', function () {
    $author = User::factory()->create(['email_verified_at' => now()]);

    $post = Post::create([
        'title' => 'Author Post',
        'slug' => 'author-post',
        'lead' => 'Lead',
        'content' => 'Content',
        'author' => $author->name,
        'is_published' => true,
        'user_id' => $author->id,
    ]);

    $response = $this->actingAs($author)
        ->post(route('comments.store', $post->id), [
            'content' => 'Author comment',
        ]);

    $response->assertRedirect(route('posts.show', $post->slug));
    $response->assertSessionHas('success', 'Komentarz został dodany!');

    $this->assertDatabaseHas('comments', [
        'post_id' => $post->id,
        'user_id' => $author->id,
        'content' => 'Author comment',
        'is_approved' => true,
    ]);
});

it('shows only approved comments on post page', function () {
    $author = User::factory()->create(['email_verified_at' => now()]);

    $post = Post::create([
        'title' => 'Visibility Post',
        'slug' => 'visibility-post',
        'lead' => 'Lead',
        'content' => 'Content',
        'author' => $author->name,
        'is_published' => true,
        'user_id' => $author->id,
    ]);

    Comment::create([
        'post_id' => $post->id,
        'user_id' => $author->id,
        'author' => 'Approved User',
        'email' => 'approved@example.com',
        'content' => 'Approved comment',
        'is_approved' => true,
    ]);

    Comment::create([
        'post_id' => $post->id,
        'user_id' => $author->id,
        'author' => 'Pending User',
        'email' => 'pending@example.com',
        'content' => 'Pending comment',
        'is_approved' => false,
    ]);

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertOk();
    $response->assertSee('Approved comment');
    $response->assertDontSee('Pending comment');
});
