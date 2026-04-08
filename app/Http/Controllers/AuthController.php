<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Throwable;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (! $request->user()->hasVerifiedEmail()) {
                $request->user()->sendEmailVerificationNotification();

                return redirect()->route('verification.notice')
                    ->with('success', 'Sprawdz skrzynke i potwierdz email, aby odblokowac funkcje konta.');
            }

            return redirect()->intended(route('posts.index'))->with('success', 'Zalogowano pomyślnie!');
        }

        return back()->withErrors([
            'email' => 'Podane dane są nieprawidłowe.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'theme' => 'light',
        ]);

        Auth::login($user);

        try {
            $user->sendEmailVerificationNotification();

            return redirect()->route('verification.notice')->with('success', 'Konto zostalo utworzone. Potwierdz adres email.');
        } catch (Throwable) {
            return redirect()->route('verification.notice')->with('error', 'Nie udalo sie wyslac wiadomosci email. Uzyj przycisku ponownej wysylki lub linku lokalnego ponizej.');
        }
    }

    public function showVerificationNotice(Request $request)
    {
        $verificationUrl = null;

        if (app()->environment('local') && config('mail.default') === 'log' && $request->user()) {
            $verificationUrl = URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(config('auth.verification.expire', 60)),
                [
                    'id' => $request->user()->getKey(),
                    'hash' => sha1($request->user()->getEmailForVerification()),
                ]
            );
        }

        return view('auth.verify-email', [
            'verificationUrl' => $verificationUrl,
        ]);
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('posts.index')->with('success', 'Adres email zostal potwierdzony.');
    }

    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('posts.index');
        }

        try {
            $request->user()->sendEmailVerificationNotification();

            return back()->with('success', 'Wyslalismy nowy link weryfikacyjny.');
        } catch (Throwable) {
            return back()->with('error', 'Nie udalo sie wyslac wiadomosci email. Sprawdz konfiguracje MAIL_* lub skorzystaj z linku lokalnego ponizej.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('posts.index'))->with('success', 'Wylogowano pomyślnie!');
    }
}
