<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns sitemap with published post urls', function () {
    $user = User::factory()->create();

    Post::create([
        'title' => 'Visible Post',
        'slug' => 'visible-post',
        'lead' => 'Lead',
        'content' => 'Body',
        'author' => $user->name,
        'is_published' => true,
        'user_id' => $user->id,
    ]);

    Post::create([
        'title' => 'Hidden Post',
        'slug' => 'hidden-post',
        'lead' => 'Lead',
        'content' => 'Body',
        'author' => $user->name,
        'is_published' => false,
        'user_id' => $user->id,
    ]);

    $response = $this->get(route('sitemap'));

    $response->assertOk();
    $response->assertHeader('Content-Type', 'application/xml');
    $response->assertSee(route('home'), false);
    $response->assertSee(route('blog.index'), false);
    $response->assertSee(route('posts.show', 'visible-post'), false);
    $response->assertDontSee(route('posts.show', 'hidden-post'), false);
});
