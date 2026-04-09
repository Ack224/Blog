<?php

use App\Mail\NewsletterDoubleOptInMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('subscribes a new newsletter email', function () {
    Mail::fake();

    $response = $this->post(route('newsletter.subscribe'), [
        'newsletter_email' => 'reader@example.com',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('newsletter_subscribers', [
        'email' => 'reader@example.com',
        'confirmed_at' => null,
        'unsubscribed_at' => null,
    ]);

    Mail::assertSent(NewsletterDoubleOptInMail::class, 1);
});

it('does not create duplicate record for already active subscriber', function () {
    NewsletterSubscriber::create([
        'email' => 'reader@example.com',
        'locale' => 'pl',
        'subscribed_at' => now(),
        'confirmed_at' => now(),
        'unsubscribe_token' => 'existing-unsubscribe-token',
    ]);

    $response = $this->post(route('newsletter.subscribe'), [
        'newsletter_email' => 'reader@example.com',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success');

    expect(NewsletterSubscriber::query()->where('email', 'reader@example.com')->count())->toBe(1);
});

it('rejects invalid newsletter email format', function () {
    $response = $this->from(route('blog.index'))->post(route('newsletter.subscribe'), [
        'newsletter_email' => 'not-an-email',
    ]);

    $response->assertRedirect(route('blog.index'));
    $response->assertSessionHasErrors('newsletter_email');
});

it('confirms newsletter subscription with valid token', function () {
    $subscriber = NewsletterSubscriber::create([
        'email' => 'reader@example.com',
        'locale' => 'pl',
        'subscribed_at' => now(),
        'confirmation_token' => 'confirm-token-123',
        'unsubscribe_token' => 'unsubscribe-token-123',
    ]);

    $response = $this->get(route('newsletter.confirm', 'confirm-token-123'));

    $response->assertRedirect(route('blog.index'));
    $response->assertSessionHas('success');

    expect($subscriber->fresh()->confirmed_at)->not->toBeNull();
    expect($subscriber->fresh()->confirmation_token)->toBeNull();
});

it('unsubscribes newsletter subscriber with valid token', function () {
    $subscriber = NewsletterSubscriber::create([
        'email' => 'reader@example.com',
        'locale' => 'pl',
        'subscribed_at' => now(),
        'confirmed_at' => now(),
        'unsubscribe_token' => 'unsubscribe-token-456',
    ]);

    $response = $this->get(route('newsletter.unsubscribe', 'unsubscribe-token-456'));

    $response->assertRedirect(route('blog.index'));
    $response->assertSessionHas('success');

    expect($subscriber->fresh()->unsubscribed_at)->not->toBeNull();
});
