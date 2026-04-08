<x-layout>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <section class="bg-white dark:bg-slate-800 rounded-lg shadow-md dark:shadow-lg p-8 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-8">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-16 bg-indigo-500 rounded-full flex items-center justify-center text-white text-xl font-bold shrink-0">
                        {{ strtoupper(substr($profileUser->name, 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">{{ __('Author profile') }}</p>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $profileUser->name }}</h1>
                        @if ($profileUser->bio)
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-300 max-w-2xl">{{ $profileUser->bio }}</p>
                        @else
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('No bio added yet.') }}</p>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col gap-3 lg:items-end">
                    <div class="grid grid-cols-3 gap-3 w-full lg:w-auto">
                        <div class="rounded-lg border border-gray-200 dark:border-slate-700 px-4 py-3 text-center min-w-24">
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Posts') }}</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $posts->total() }}</p>
                        </div>
                        <div class="rounded-lg border border-gray-200 dark:border-slate-700 px-4 py-3 text-center min-w-24">
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Followers') }}</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $followersCount }}</p>
                        </div>
                        <div class="rounded-lg border border-gray-200 dark:border-slate-700 px-4 py-3 text-center min-w-24">
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Following') }}</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $followingCount }}</p>
                        </div>
                    </div>

                    @auth
                        @if (auth()->id() === $profileUser->id)
                            <a href="{{ route('users.edit') }}"
                                class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-md text-sm font-medium transition-colors">
                                {{ __('Edit profile') }}
                            </a>
                        @else
                            @if (auth()->user()->hasVerifiedEmail())
                                @if ($isFollowing)
                                    <form method="POST" action="{{ route('follows.destroy', $profileUser) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 bg-rose-100 text-rose-700 hover:bg-rose-200 rounded-md text-sm font-medium transition-colors">
                                            {{ __('Unfollow') }}
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('follows.store', $profileUser) }}">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-md text-sm font-medium transition-colors">
                                            {{ __('Follow author') }}
                                        </button>
                                    </form>
                                @endif
                            @else
                                <p class="text-sm text-amber-700 bg-amber-50 border border-amber-200 rounded-md px-3 py-2">
                                    {{ __('Verify your email to follow authors.') }}
                                </p>
                            @endif
                        @endif
                    @endauth
                </div>
            </div>

            @if ($profileUser->website_url || $profileUser->github_url || $profileUser->x_url)
                <div class="mt-5 pt-5 border-t border-gray-200 dark:border-slate-700">
                    <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ __('Special links') }}</p>
                    <div class="flex flex-wrap gap-3 text-sm">
                        @if ($profileUser->website_url)
                            <a href="{{ $profileUser->website_url }}" target="_blank" rel="noopener noreferrer"
                                class="text-indigo-600 dark:text-indigo-400 hover:underline">WWW</a>
                        @endif
                        @if ($profileUser->github_url)
                            <a href="{{ $profileUser->github_url }}" target="_blank" rel="noopener noreferrer"
                                class="text-indigo-600 dark:text-indigo-400 hover:underline">GitHub</a>
                        @endif
                        @if ($profileUser->x_url)
                            <a href="{{ $profileUser->x_url }}" target="_blank" rel="noopener noreferrer"
                                class="text-indigo-600 dark:text-indigo-400 hover:underline">X</a>
                        @endif
                    </div>
                </div>
            @endif
        </section>

        <section>
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2 mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Author posts') }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Latest published content from this author.') }}</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($posts as $post)
                    <article
                        class="bg-white dark:bg-slate-800 rounded-lg shadow-md dark:shadow-lg hover:shadow-xl dark:hover:shadow-2xl transition-all duration-300 overflow-hidden cursor-pointer"
                        data-card-url="{{ route('posts.show', $post->slug) }}"
                        tabindex="0"
                    >
                        <div
                            class="h-40 bg-linear-to-br from-indigo-500 to-purple-600 dark:from-indigo-600 dark:to-purple-700 flex items-center justify-center overflow-hidden">
                            @if ($post->photo)
                                <img src="{{ asset('storage/' . $post->photo) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-5xl">📝</span>
                            @endif
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                                <a href="{{ route('posts.show', $post->slug) }}"
                                    class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3">
                                {{ $post->lead ?? Str::limit(strip_tags($post->content), 120) }}
                            </p>
                            <div class="mt-3 flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                                <span>❤ {{ $post->liked_by_users_count }}</span>
                                <span>🔖 {{ $post->bookmarked_by_count }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full bg-white dark:bg-slate-800 rounded-lg shadow-md p-8 text-center">
                        <p class="text-gray-600 dark:text-gray-400">{{ __('This author has no published posts yet.') }}</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10 flex justify-center">
                {{ $posts->links('pagination::tailwind') }}
            </div>
        </section>
    </main>
</x-layout>
