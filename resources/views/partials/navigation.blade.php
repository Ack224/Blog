    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('posts.index') }}" class="text-2xl font-bold text-gray-900 hover:text-indigo-600 transition-colors flex items-center gap-2">
                    📝 Blog
                </a>

                <!-- Center Navigation -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('posts.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition">
                        Posty
                    </a>
                    @auth
                        <a href="{{ route('posts.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition">
                            ➕ Nowy Post
                        </a>
                    @endauth
                </div>

                <!-- Right Side - Auth -->
                <div class="flex items-center space-x-4">
                    @guest
                        <!-- Guest Menu -->
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition">
                            Zaloguj się
                        </a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 transition">
                            Zarejestruj się
                        </a>
                    @else
                        <!-- User Menu Dropdown -->
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                                <div class="hidden sm:block">
                                    <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                            </div>

                            <!-- Logout Form -->
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="ml-4 px-3 py-2 text-sm text-red-600 hover:text-red-700 hover:bg-red-50 rounded-md transition font-medium">
                                    Wyloguj
                                </button>
                            </form>
                        </div>
                    @endguest

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md text-gray-700 hover:text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 space-y-2">
                <a href="{{ route('posts.index') }}" class="block text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">
                    Posty
                </a>
                @auth
                    <a href="{{ route('posts.create') }}" class="block bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700 text-center">
                        ➕ Nowy Post
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        mobileMenuBtn?.addEventListener('click', () => {
            mobileMenu?.classList.toggle('hidden');
        });
    </script>
