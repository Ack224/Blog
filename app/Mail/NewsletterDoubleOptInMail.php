<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterDoubleOptInMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public NewsletterSubscriber $subscriber) {}

    public function build(): self
    {
        return $this
            ->subject(__('Confirm your newsletter subscription'))
            ->view('emails.newsletter-double-opt-in');
    }
}
