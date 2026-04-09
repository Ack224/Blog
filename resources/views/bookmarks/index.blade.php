<x-layout>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white transition-colors">{{ __('My Bookmarks') }}</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400 transition-colors">
                {{ __('Saved articles you want to revisit.') }}
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($bookmarks as $post)
                <article
                    class="bg-white dark:bg-slate-800 rounded-lg shadow-md dark:shadow-lg hover:shadow-xl dark:hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    <div
                        class="h-48 bg-linear-to-br from-indigo-500 to-purple-600 dark:from-indigo-600 dark:to-purple-700 flex items-center justify-center overflow-hidden">
                        @if ($post->photo)
                            <img src="{{ asset('storage/' . $post->photo) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-6xl">📝</span>
                        @endif
                    </div>

                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            <a href="{{ route('posts.show', $post->slug) }}"
                                class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3 transition-colors">
                            {{ $post->lead ?? Str::limit(strip_tags($post->content), 140) }}
                        </p>

                        <div class="mb-4 flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                            <span>❤ {{ $post->liked_by_users_count }}</span>
                            <span>🔖 {{ $post->bookmarked_by_count }}</span>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-slate-700">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $post->created_at->format('d.m.Y') }}
                            </span>

                            <form method="POST" action="{{ route('bookmarks.destroy', $post) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-sm text-rose-600 dark:text-rose-400 hover:text-rose-700 dark:hover:text-rose-300 font-medium transition-colors">
                                    {{ __('Remove bookmark') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full bg-white dark:bg-slate-800 rounded-lg shadow-md p-10 text-center">
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('You have no saved posts yet.') }}</p>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('Go to the posts list and save your first article.') }}</p>
                    <a href="{{ route('blog.index') }}"
                        class="inline-block mt-5 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        {{ __('Browse posts') }}
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-12 flex justify-center">
            {{ $bookmarks->links('pagination::tailwind') }}
        </div>
    </main>
</x-layout>
