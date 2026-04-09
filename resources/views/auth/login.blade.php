<x-layout>
    <div class="min-h-screen flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Gradient header -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-t-lg px-6 py-8">
                <h1 class="text-3xl font-bold text-white text-center">Zaloguj się</h1>
                <p class="text-blue-100 text-center mt-2">Wróć do swojego konta</p>
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

                <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                    @csrf

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
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:text-gray-100 transition-colors"
                            placeholder="twoj@email.com"
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
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:text-gray-100 transition-colors"
                            placeholder="••••••••"
                        >
                    </div>

                    <!-- Remember me -->
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                            Zapamiętaj mnie
                        </label>
                    </div>

                    <!-- Submit button -->
                    <button
                        type="submit"
                        id="login-button"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                        onclick="this.disabled=true; this.querySelector('span:first-child').classList.remove('hidden'); this.form.submit();"
                    >
                        <span class="hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        <span>Zaloguj się</span>
                    </button>
                </form>

                <!-- Register link -->
                <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
                    Nie masz konta?
                    <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                        Zarejestruj się
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-layout>
