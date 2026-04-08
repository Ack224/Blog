<?php

namespace App\Http\Controllers;

use App\Mail\NewsletterDoubleOptInMail;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class NewsletterSubscriptionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'newsletter_email' => ['required', 'email', 'max:255'],
        ]);

        $email = strtolower($validated['newsletter_email']);

        $subscriber = NewsletterSubscriber::query()->firstOrNew([
            'email' => $email,
        ]);

        if ($subscriber->exists && $subscriber->isActive()) {
            return back()->with('success', __('You are already subscribed to the newsletter.'));
        }

        $subscriber->fill([
            'locale' => app()->getLocale(),
            'subscribed_at' => now(),
            'confirmed_at' => null,
            'unsubscribed_at' => null,
            'confirmation_token' => Str::random(80),
            'unsubscribe_token' => Str::random(80),
        ]);

        $subscriber->save();

        Mail::to($subscriber->email)->send(new NewsletterDoubleOptInMail($subscriber));

        return back()->with('success', __('Please confirm your email to complete newsletter subscription.'));
    }

    public function confirm(string $token): RedirectResponse
    {
        $subscriber = NewsletterSubscriber::query()
            ->where('confirmation_token', $token)
            ->firstOrFail();

        $subscriber->update([
            'confirmed_at' => now(),
            'unsubscribed_at' => null,
            'confirmation_token' => null,
        ]);

        return redirect()->route('posts.index')
            ->with('success', __('Your newsletter subscription has been confirmed.'));
    }

    public function unsubscribe(string $token): RedirectResponse
    {
        $subscriber = NewsletterSubscriber::query()
            ->where('unsubscribe_token', $token)
            ->firstOrFail();

        $subscriber->update([
            'unsubscribed_at' => now(),
            'confirmation_token' => null,
        ]);

        return redirect()->route('posts.index')
            ->with('success', __('You have been unsubscribed from the newsletter.'));
    }
}
