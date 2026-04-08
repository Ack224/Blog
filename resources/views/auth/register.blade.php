<x-layout>
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Gradient header -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-600 dark:to-emerald-700 rounded-t-lg px-6 py-8">
                <h1 class="text-3xl font-bold text-white text-center">Zarejestruj się</h1>
                <p class="text-green-100 text-center mt-2">Dołącz do naszej społeczności</p>
            </div>

            <!-- Form card -->
            <div class="bg-white dark:bg-slate-900 rounded-b-lg shadow-lg p-8">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900 border border-red-200 dark:border-red-700 rounded-lg">
                        <div class="text-red-700 dark:text-red-200 text-sm font-medium">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                    @csrf

                    <!-- Name field -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                            Pełne imię i nazwisko
                        </label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-800 dark:text-gray-100 transition-colors"
                            placeholder="Jan Kowalski"
                        >
                    </div>

                    <!-- Email field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                            Adres email
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-800 dark:text-gray-100 transition-colors"
                            placeholder="jan@example.com"
                        >
                    </div>

                    <!-- Password field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                            Hasło
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-800 dark:text-gray-100 transition-colors"
                            placeholder="••••••••"
                        >
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Minimum 8 znaków</p>
                    </div>

                    <!-- Password confirmation -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">
                            Potwierdź hasło
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-800 dark:text-gray-100 transition-colors"
                            placeholder="••••••••"
                        >
                    </div>

                    <!-- Submit button -->
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 mt-6"
                    >
                        Zarejestruj się
                    </button>
                </form>

                <!-- Login link -->
                <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    Masz już konto?
                    <a href="{{ route('login') }}" class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium">
                        Zaloguj się
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layout>
