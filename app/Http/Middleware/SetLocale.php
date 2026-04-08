<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['pl', 'en'];

        $locale = $request->session()->get('locale');

        if (! $locale && $request->user()) {
            $locale = $request->user()->locale;
        }

        if (! in_array($locale, $supportedLocales, true)) {
            $locale = config('app.locale', 'pl');
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
