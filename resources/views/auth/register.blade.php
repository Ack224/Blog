<x-layout>
    <main class="flex items-center justify-center min-h-screen bg-gray-50 px-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-8 text-white">
                    <h1 class="text-3xl font-bold">Zarejestruj się</h1>
                    <p class="mt-2 text-purple-100">Dołącz do naszej społeczności blogerów</p>
                </div>

                <!-- Form -->
                <div class="px-6 py-8">
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-red-700 font-medium">Błędy w formularzu</p>
                            <ul class="mt-2 text-sm text-red-600 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Imię i nazwisko
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="Jan Kowalski"
                            >
                            @error('name')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="twój@email.com"
                            >
                            @error('email')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                Hasło (minimum 8 znaków)
                            </label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="••••••••"
                            >
                            @error('password')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                Potwierdź hasło
                            </label>
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                placeholder="••••••••"
                            >
                            @error('password_confirmation')
                                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Terms -->
                        <p class="text-xs text-gray-600">
                            Rejestrując się, akceptujesz nasze warunki użytkowania.
                        </p>

                        <!-- Submit -->
                        <button
                            type="submit"
                            class="w-full bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors mt-6"
                        >
                            Zarejestruj się
                        </button>
                    </form>

                    <!-- Login Link -->
                    <p class="mt-6 text-center text-gray-600">
                        Już masz konto?
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                            Zaloguj się
                        </a>
                    </p>
                </div>
            </div>

            <!-- Features -->
            <div class="mt-6 grid grid-cols-3 gap-4 text-center text-sm">
                <div class="p-3 bg-white rounded-lg shadow-sm">
                    <div class="text-2xl mb-1">📝</div>
                    <p class="text-gray-600">Tworzyć posty</p>
                </div>
                <div class="p-3 bg-white rounded-lg shadow-sm">
                    <div class="text-2xl mb-1">💬</div>
                    <p class="text-gray-600">Komentować</p>
                </div>
                <div class="p-3 bg-white rounded-lg shadow-sm">
                    <div class="text-2xl mb-1">🔖</div>
                    <p class="text-gray-600">Zbierać</p>
                </div>
            </div>
        </div>
    </main>
</x-layout>
