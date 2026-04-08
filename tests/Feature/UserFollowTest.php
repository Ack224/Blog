<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('allows verified user to follow another user', function () {
    $follower = User::factory()->create(['email_verified_at' => now()]);
    $author = User::factory()->create(['email_verified_at' => now()]);

    $response = $this->actingAs($follower)->post(route('follows.store', $author));

    $response->assertRedirect();

    $this->assertDatabaseHas('followers', [
        'follower_user_id' => $follower->id,
        'following_user_id' => $author->id,
    ]);
});

it('allows verified user to unfollow a followed user', function () {
    $follower = User::factory()->create(['email_verified_at' => now()]);
    $author = User::factory()->create(['email_verified_at' => now()]);

    $follower->following()->attach($author->id);

    $response = $this->actingAs($follower)->delete(route('follows.destroy', $author));

    $response->assertRedirect();

    $this->assertDatabaseMissing('followers', [
        'follower_user_id' => $follower->id,
        'following_user_id' => $author->id,
    ]);
});

it('does not allow following self', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);

    $response = $this->actingAs($user)->post(route('follows.store', $user));

    $response->assertForbidden();

    $this->assertDatabaseMissing('followers', [
        'follower_user_id' => $user->id,
        'following_user_id' => $user->id,
    ]);
});

it('blocks unverified user from following', function () {
    $follower = User::factory()->unverified()->create();
    $author = User::factory()->create(['email_verified_at' => now()]);

    $response = $this->actingAs($follower)->post(route('follows.store', $author));

    $response->assertRedirect(route('verification.notice'));

    $this->assertDatabaseMissing('followers', [
        'follower_user_id' => $follower->id,
        'following_user_id' => $author->id,
    ]);
});
