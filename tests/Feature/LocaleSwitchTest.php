<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('switches locale for guest session', function () {
    $response = $this->post(route('locale.switch', 'en'));

    $response->assertRedirect();
    $response->assertSessionHas('locale', 'en');
});

it('switches locale and persists it for authenticated user', function () {
    $user = User::factory()->create([
        'locale' => 'pl',
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->post(route('locale.switch', 'en'));

    $response->assertRedirect();
    $response->assertSessionHas('locale', 'en');

    expect($user->fresh()->locale)->toBe('en');
});

it('returns 404 for unsupported locale', function () {
    $response = $this->post(route('locale.switch', 'de'));

    $response->assertNotFound();
});

it('renders blog page in english when locale is set to en', function () {
    $this->withSession(['locale' => 'en']);

    $response = $this->get(route('blog.index'));

    $response->assertOk();
    $response->assertSee('Latest Posts');
});
