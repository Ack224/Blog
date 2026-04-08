<x-layout>
    <main class="flex items-center justify-center min-h-screen bg-gray-50 px-4">
        <div class="w-full max-w-md">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-8 text-white">
                    <h1 class="text-3xl font-bold">Zaloguj się</h1>
                    <p class="mt-2 text-indigo-100">Wróć do swojego bloga</p>
                </div>

                <!-- Form -->
                <div class="px-6 py-8">
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-red-700 font-medium">Błędne dane logowania</p>
                            <ul class="mt-2 text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                        @csrf

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
                                autofocus
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
                                Hasło
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

                        <!-- Remember Me -->
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                id="remember"
                                name="remember"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Pamiętaj mnie
                            </label>
                        </div>

                        <!-- Submit -->
                        <button
                            type="submit"
                            class="w-full bg-indigo-600 text-white font-medium py-2 px-4 rounded-lg hover:bg-indigo-700 transition-colors mt-6"
                        >
                            Zaloguj się
                        </button>
                    </form>

                    <!-- Sign Up Link -->
                    <p class="mt-6 text-center text-gray-600">
                        Nie masz konta?
                        <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                            Zarejestruj się
                        </a>
                    </p>

                    <!-- Admin Link -->
                    <p class="mt-4 text-center text-gray-500 text-sm">
                        <a href="/admin" class="text-gray-600 hover:text-gray-700">Panel administracyjny</a>
                    </p>
                </div>
            </div>

            <!-- Demo Info -->
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg text-sm text-blue-700">
                <p class="font-medium">💡 Demo kontami:</p>
                <p class="mt-1">Zaloguj się aby tworzyć, edytować i komentować posty</p>
            </div>
        </div>
    </main>
</x-layout>
