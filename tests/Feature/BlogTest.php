<?php

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

describe('Authentication', function () {
    it('displays register page', function () {
        $response = $this->get('/register');
        expect($response->status())->toBe(200);
    });

    it('can register new user', function () {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        expect($response->status())->toBe(302);
        expect(User::where('email', 'test@example.com')->exists())->toBe(true);
    });

    it('displays login page', function () {
        $response = $this->get('/login');
        expect($response->status())->toBe(200);
    });

    it('can login user', function () {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        expect($response->status())->toBe(302);
    });

    it('can logout user', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');
        expect($response->status())->toBe(302);
    });
});

describe('Posts', function () {
    it('displays posts list', function () {
        $post = Post::factory()->create(['title' => 'Test Post']);
        $response = $this->get('/posts');
        expect($response->status())->toBe(200);
        expect($response->content())->toContain('Test Post');
    });

    it('authenticated user can create post', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/posts', [
            'title' => 'New Post',
            'slug' => 'new-post',
            'content' => 'Post content',
            'author' => 'Test Author',
        ]);

        expect($response->status())->toBe(302);
        expect(Post::where('title', 'New Post')->exists())->toBe(true);
    });

    it('displays post detail', function () {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id, 'title' => 'Test Post']);

        // Load user relationship
        $post->load('user');

        $response = $this->get('/posts/' . $post->slug);
        expect($response->status())->toBe(200);
    });

    it('only author can edit post', function () {
        $author = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id]);

        $response = $this->actingAs($other)->get('/posts/' . $post->id . '/edit');
        expect($response->status())->toBe(403);

        $response = $this->actingAs($author)->get('/posts/' . $post->id . '/edit');
        expect($response->status())->toBe(200);
    });

    it('only author can delete post', function () {
        $author = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $author->id]);

        $response = $this->actingAs($other)->delete('/posts/' . $post->id);
        expect($response->status())->toBe(403);

        $response = $this->actingAs($author)->delete('/posts/' . $post->id);
        expect($response->status())->toBe(302);
    });
});

describe('Comments', function () {
    it('authenticated user can comment', function () {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->post('/posts/' . $post->id . '/comments', [
            'author' => 'Test User',
            'email' => 'test@test.com',
            'content' => 'Test comment',
        ]);

        expect($response->status())->toBe(302);
        expect(Comment::where('content', 'Test comment')->exists())->toBe(true);
    });

    it('can like comment', function () {
        $user = User::factory()->create();
        $post = Post::factory()->create();
        $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);

        $response = $this->actingAs($user)->post(
            '/posts/' . $post->id . '/comments/' . $comment->id . '/like'
        );

        expect($response->status())->toBe(302);
        $comment->refresh();
        expect($comment->likes_count)->toBe(1);
    });
});

describe('Follow System', function () {
    it('authenticated user can follow author', function () {
        $follower = User::factory()->create();
        $author = User::factory()->create();

        $response = $this->actingAs($follower)->post('/users/' . $author->id . '/follow');

        expect($response->status())->toBe(302);
        expect($follower->following()->where('followed_id', $author->id)->exists())->toBe(true);
    });
});

describe('Bookmarks', function () {
    it('authenticated user can bookmark post', function () {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $response = $this->actingAs($user)->post('/posts/' . $post->id . '/bookmark');

        expect($response->status())->toBe(302);
        expect($user->bookmarks()->where('post_id', $post->id)->exists())->toBe(true);
    });
});
