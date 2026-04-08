<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows author to view own draft post page', function () {
    $user = User::factory()->create();

    $post = Post::create([
        'title' => 'My Draft Post',
        'slug' => 'my-draft-post',
        'lead' => 'Draft lead',
        'content' => 'Draft content',
        'author' => $user->name,
        'is_published' => false,
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)->get(route('posts.show', $post->slug));

    $response->assertOk();
    $response->assertSee('My Draft Post');
});

it('returns 404 for guest when post is a draft', function () {
    $user = User::factory()->create();

    $post = Post::create([
        'title' => 'Hidden Draft Post',
        'slug' => 'hidden-draft-post',
        'lead' => 'Draft lead',
        'content' => 'Draft content',
        'author' => $user->name,
        'is_published' => false,
        'user_id' => $user->id,
    ]);

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertNotFound();
});
