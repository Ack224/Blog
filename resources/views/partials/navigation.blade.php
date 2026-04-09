    <!-- Navigation -->
    <nav class="bg-white dark:bg-slate-900 shadow-sm border-b border-gray-200 dark:border-slate-700 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                        📝 Blog
                    </a>
                </div>

                <!-- Navigation items -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <a href="{{ route('home') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        {{ __('Home') }}
                    </a>

                    <a href="{{ route('blog.index') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        {{ __('Blog') }}
                    </a>

                    <a href="{{ route('contact') }}"
                        class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        {{ __('Contact') }}
                    </a>

                    <div class="flex items-center gap-1 rounded-md border border-gray-200 dark:border-slate-700 p-1">
                        <form method="POST" action="{{ route('locale.switch', 'pl') }}">
                            @csrf
                            <button type="submit"
                                class="w-12 h-9 text-xs font-semibold rounded-md transition-colors {{ app()->getLocale() === 'pl' ? 'bg-indigo-600 text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                                PL
                            </button>
                        </form>
                        <form method="POST" action="{{ route('locale.switch', 'en') }}">
                            @csrf
                            <button type="submit"
                                class="w-12 h-9 text-xs font-semibold rounded-md transition-colors {{ app()->getLocale() === 'en' ? 'bg-indigo-600 text-white' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                                EN
                            </button>
                        </form>
                    </div>

                    @auth
                        <a href="{{ route('users.show', auth()->user()) }}"
                            class="text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            {{ __('My Profile') }}
                        </a>

                        <!-- New Post button -->
                        <a href="{{ route('posts.create') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            + {{ __('New Post') }}
                        </a>

                        <!-- Theme toggle button -->
                        <button onclick="window.themeManager && window.themeManager.toggle()"
                            class="p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-md transition-colors"
                            title="{{ __('Toggle theme') }}" aria-label="{{ __('Toggle theme') }}">
                            <svg class="w-5 h-5 hidden dark:block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                            </svg>
                            <svg class="w-5 h-5 block dark:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                            </svg>
                        </button>

                        <!-- User dropdown -->
                        <div class="relative group">
                            <button class="flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors">
                                <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div class="absolute right-0 mt-0 w-48 bg-white dark:bg-slate-800 rounded-lg shadow-lg border border-gray-200 dark:border-slate-700 hidden group-hover:block transition-colors z-10">
                                <a href="{{ route('bookmarks.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-t-lg transition-colors">
                                    {{ __('My Bookmarks') }}
                                </a>
                                <a href="{{ route('users.show', auth()->user()) }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                    {{ __('My Profile') }}
                                </a>
                                <a href="{{ route('users.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                                    {{ __('Settings') }}
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="block">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-b-lg transition-colors">
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Theme toggle button (guest) -->
                        <button onclick="window.themeManager && window.themeManager.toggle()"
                            class="p-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-md transition-colors"
                            title="{{ __('Toggle theme') }}" aria-label="{{ __('Toggle theme') }}">
                            <svg class="w-5 h-5 hidden dark:block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                            </svg>
                            <svg class="w-5 h-5 block dark:hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                            </svg>
                        </button>

                        <!-- Auth buttons -->
                        <a href="{{ route('login') }}"
                            class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            {{ __('Login') }}
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                            {{ __('Register') }}
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
