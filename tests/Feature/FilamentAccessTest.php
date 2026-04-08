<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('denies admin panel access for non admin user', function () {
    $user = User::factory()->create([
        'is_admin' => false,
    ]);

    $response = $this->actingAs($user)->get('/admin');

    $response->assertForbidden();
});

it('allows admin panel access for admin user', function () {
    $user = User::factory()->admin()->create();

    $response = $this->actingAs($user)->get('/admin');

    $response->assertOk();
});
