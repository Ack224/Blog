<x-layout>
    <main class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <section class="bg-white dark:bg-slate-800 rounded-lg shadow-md dark:shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Potwierdz adres email</h1>
            <p class="mt-3 text-gray-600 dark:text-gray-300 leading-relaxed">
                Aby aktywowac funkcje konta (dodawanie postow, komentarze, zakladki), potwierdz adres email
                klikajac link wyslany po rejestracji.
            </p>

            @if (session('success'))
                <div class="mt-6 rounded-md bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
                @csrf
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-md font-medium transition-colors">
                    Wyslij link ponownie
                </button>
            </form>

            @if (!empty($verificationUrl))
                <div class="mt-6 rounded-md bg-blue-50 border border-blue-200 text-blue-900 px-4 py-3 text-sm space-y-2">
                    <p class="font-semibold">Tryb lokalny: MAIL_MAILER=log</p>
                    <p>Mail trafia do pliku logow, dlatego mozesz od razu uzyc ponizszego linku weryfikacyjnego:</p>
                    <a href="{{ $verificationUrl }}" class="underline break-all text-blue-700 hover:text-blue-900">
                        {{ $verificationUrl }}
                    </a>
                </div>
            @endif

            <div class="mt-6 text-sm text-gray-600 dark:text-gray-400">
                Bledny adres? Wyloguj sie i zarejestruj ponownie poprawnym emailem.
            </div>
        </section>
    </main>
</x-layout>
