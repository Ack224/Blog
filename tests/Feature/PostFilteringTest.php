<?php

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('filters posts by search phrase', function () {
    $user = User::factory()->create();

    Post::create([
        'title' => 'Laravel Search Guide',
        'slug' => 'laravel-search-guide',
        'lead' => 'Everything about search.',
        'content' => 'Search and filtering in Laravel.',
        'author' => $user->name,
        'is_published' => true,
        'user_id' => $user->id,
        'category' => 'Laravel',
    ]);

    Post::create([
        'title' => 'Docker Basics',
        'slug' => 'docker-basics',
        'lead' => 'Container fundamentals.',
        'content' => 'Intro to docker.',
        'author' => $user->name,
        'is_published' => true,
        'user_id' => $user->id,
        'category' => 'DevOps',
    ]);

    $response = $this->get(route('posts.index', ['q' => 'Search Guide']));

    $response->assertOk();
    $response->assertSee('Laravel Search Guide');
    $response->assertDontSee('Docker Basics');
});

it('filters posts by category', function () {
    $user = User::factory()->create();

    Post::create([
        'title' => 'Category Laravel Post',
        'slug' => 'category-laravel-post',
        'lead' => 'Laravel category content.',
        'content' => 'Laravel category body.',
        'author' => $user->name,
        'is_published' => true,
        'user_id' => $user->id,
        'category' => 'Laravel',
    ]);

    Post::create([
        'title' => 'Category React Post',
        'slug' => 'category-react-post',
        'lead' => 'React category content.',
        'content' => 'React category body.',
        'author' => $user->name,
        'is_published' => true,
        'user_id' => $user->id,
        'category' => 'React',
    ]);

    $response = $this->get(route('posts.index', ['category' => 'React']));

    $response->assertOk();
    $response->assertSee('Category React Post');
    $response->assertDontSee('Category Laravel Post');
});

it('filters posts by tag slug', function () {
    $user = User::factory()->create();

    $tagLaravel = Tag::create([
        'name' => 'laravel',
        'slug' => 'laravel',
    ]);

    $tagDocker = Tag::create([
        'name' => 'docker',
        'slug' => 'docker',
    ]);

    $postWithLaravelTag = Post::create([
        'title' => 'Tagged Laravel Post',
        'slug' => 'tagged-laravel-post',
        'lead' => 'Tagged with laravel.',
        'content' => 'Tag relation post body.',
        'author' => $user->name,
        'is_published' => true,
        'user_id' => $user->id,
        'category' => 'Laravel',
    ]);

    $postWithDockerTag = Post::create([
        'title' => 'Tagged Docker Post',
        'slug' => 'tagged-docker-post',
        'lead' => 'Tagged with docker.',
        'content' => 'Another tagged post body.',
        'author' => $user->name,
        'is_published' => true,
        'user_id' => $user->id,
        'category' => 'DevOps',
    ]);

    $postWithLaravelTag->tags()->attach($tagLaravel->id);
    $postWithDockerTag->tags()->attach($tagDocker->id);

    $response = $this->get(route('posts.index', ['tag' => 'laravel']));

    $response->assertOk();
    $response->assertSee('Tagged Laravel Post');
    $response->assertDontSee('Tagged Docker Post');
});
