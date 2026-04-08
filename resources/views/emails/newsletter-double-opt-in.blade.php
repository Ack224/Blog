<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Confirm your newsletter subscription') }}</title>
</head>

<body style="font-family: Arial, sans-serif; color: #111827; line-height: 1.6;">
    <p>{{ __('Hello!') }}</p>

    <p>{{ __('Thanks for subscribing. Please confirm your email to start receiving the newsletter.') }}</p>

    <p>
        <a href="{{ route('newsletter.confirm', $subscriber->confirmation_token) }}">{{ __('Confirm subscription') }}</a>
    </p>

    <p>{{ __('If you did not request this, you can ignore this email.') }}</p>

    <p>
        {{ __('Unsubscribe any time:') }}
        <a href="{{ route('newsletter.unsubscribe', $subscriber->unsubscribe_token) }}">{{ __('Unsubscribe') }}</a>
    </p>
</body>

</html>
