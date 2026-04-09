<x-layout
    :title="$post->title . ' | Blog'"
    :description="$post->meta_description ?? $post->lead ?? Str::limit(strip_tags($post->content), 160)"
    :canonical="route('posts.show', $post->slug)"
    ogType="article"
>
    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->title,
            'description' => $post->meta_description ?? $post->lead,
            'author' => [
                '@type' => 'Person',
                'name' => $post->author,
            ],
            'datePublished' => optional($post->created_at)->toIso8601String(),
            'dateModified' => optional($post->updated_at)->toIso8601String(),
            'mainEntityOfPage' => route('posts.show', $post->slug),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Post Header -->
        <article class="bg-white dark:bg-slate-800 rounded-lg shadow-md dark:shadow-lg overflow-hidden mb-8 transition-colors">
            <!-- Featured Image -->
            <div class="h-96 bg-linear-to-br from-indigo-500 to-purple-600 dark:from-indigo-600 dark:to-purple-700 flex items-center justify-center overflow-hidden">
                @if ($post->photo)
                    <img src="{{ asset('storage/' . $post->photo) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                @else
                    <span class="text-9xl">📝</span>
                @endif
            </div>

            <!-- Post Content -->
            <div class="p-8">
                <!-- Meta Info -->
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-slate-700 transition-colors">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-12 h-12 bg-gray-300 dark:bg-slate-700 rounded-full flex items-center justify-center text-lg font-semibold text-gray-900 dark:text-gray-100 transition-colors">
                            {{ strtoupper(substr($post->author, 0, 2)) }}
                        </div>
                        <div>
                            @if ($post->user)
                                <a href="{{ route('users.show', $post->user) }}" class="font-semibold text-gray-900 dark:text-gray-100 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    {{ $post->author }}
                                </a>
                            @else
                                <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $post->author }}</p>
                            @endif
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Published on') }}: {{ $post->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="ml-auto flex gap-2">
                        @if ($post->is_published)
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-semibold rounded-full transition-colors">
                                {{ __('Published') }}
                            </span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-200 text-xs font-semibold rounded-full transition-colors">
                                {{ __('Draft') }}
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4 transition-colors">
                    {{ $post->title }}
                </h1>

                @if ($post->lead)
                    <!-- Lead -->
                    <p class="text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed transition-colors">
                        {{ $post->lead }}
                    </p>
                @endif

                <!-- Content -->
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 dark:text-gray-200 mb-4 leading-relaxed whitespace-pre-line transition-colors">
                        {!! $post->content !!}
                    </p>
                </div>

                <!-- Tags -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-slate-700 transition-colors">
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">{{ __('Tags') }}:</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse ($post->tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}"
                                class="px-3 py-1 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-200 text-sm rounded-full hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
                                #{{ $tag->name }}
                            </a>
                        @empty
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('No tags for this post yet.') }}</span>
                        @endforelse
                    </div>
                </div>

                <!-- Social Share -->
                <div class="mt-6 flex items-center gap-4 flex-wrap">
                    <div class="text-sm text-gray-500 dark:text-gray-400 mr-2 flex items-center gap-3">
                        <span>❤ {{ $post->liked_by_users_count }}</span>
                        <span>🔖 {{ $post->bookmarked_by_count }}</span>
                    </div>

                    @auth
                        <form method="POST" action="{{ route('posts.like', $post) }}">
                            @csrf
                            <button type="submit"
                                class="px-3 py-1.5 text-sm bg-amber-100 text-amber-800 hover:bg-amber-200 rounded-md font-medium transition-colors">
                                {{ $isLiked ? __('Unlike post') : __('Like post') }}
                            </button>
                        </form>

                        @if ($isBookmarked)
                            <form method="POST" action="{{ route('bookmarks.destroy', $post) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1.5 text-sm bg-rose-100 text-rose-700 hover:bg-rose-200 rounded-md font-medium transition-colors">
                                    {{ __('Remove bookmark') }}
                                </button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('bookmarks.store', $post) }}">
                                @csrf
                                <button type="submit"
                                    class="px-3 py-1.5 text-sm bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-md font-medium transition-colors">
                                    {{ __('Save bookmark') }}
                                </button>
                            </form>
                        @endif
                    @endauth

                    <span class="text-sm text-gray-600 dark:text-gray-300">{{ __('Share') }}:</span>
                    <button class="text-blue-600 hover:text-blue-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </button>
                    <button class="text-sky-500 hover:text-sky-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                        </svg>
                    </button>
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <section class="bg-white dark:bg-slate-800 rounded-lg shadow-md dark:shadow-lg p-8 transition-colors">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                {{ __('Comments') }} ({{ $post->comments->count() }})
            </h2>

            <!-- Comment Form -->
            <div class="mb-8 pb-8 border-b border-gray-200 dark:border-slate-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Add comment') }}</h3>
                @auth
                    @if (auth()->user()->hasVerifiedEmail())
                        <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">{{ __('Commenting as') }}: <span class="font-semibold">{{ auth()->user()->name }}</span></p>
                        <form method="POST" action="{{ route('comments.store', $post->id) }}" class="space-y-4">
                            @csrf
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('Comment') }} *
                                </label>
                                <textarea id="content" name="content" required rows="5"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"
                                    placeholder="{{ __('Share your thoughts...') }}"></textarea>
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                                    {{ __('Publish comment') }}
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="rounded-md bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 text-sm">
                            {{ __('To add comments, verify your email address.') }}
                            <a href="{{ route('verification.notice') }}" class="font-semibold underline">{{ __('Go to verification') }}</a>
                        </div>
                    @endif
                @else
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold">{{ __('Login') }}</a>, {{ __('to add a comment.') }}
                    </p>
                @endauth
            </div>

            <!-- Comments List -->
            <div class="space-y-6">
                @forelse ($post->comments as $comment)
                    <div class="flex gap-4">
                        <div class="shrink-0">
                            <div
                                class="w-12 h-12 bg-linear-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($comment->author, 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-50 dark:bg-slate-900 rounded-lg p-4 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-gray-900 dark:text-gray-100">{{ $comment->author }}</h4>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700 dark:text-gray-200 leading-relaxed">
                                    {{ $comment->content }}
                                </p>
                                <div class="mt-3 flex items-center gap-4 flex-wrap">
                                    @auth
                                        <details>
                                            <summary class="cursor-pointer text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                                {{ __('Reply') }}
                                            </summary>
                                            <form method="POST" action="{{ route('comments.reply', $comment) }}" class="mt-3 space-y-2">
                                                @csrf
                                                <textarea name="content" rows="3" required
                                                    class="w-full px-3 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100"
                                                    placeholder="{{ __('Share your thoughts...') }}"></textarea>
                                                <button type="submit" class="px-3 py-1.5 text-sm bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                                                    {{ __('Publish comment') }}
                                                </button>
                                            </form>
                                        </details>

                                        <form method="POST" action="{{ route('comments.like', $comment) }}">
                                            @csrf
                                            <button type="submit" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                                </svg>
                                                <span>{{ $comment->likes_count }}</span>
                                            </button>
                                        </form>
                                    @endauth
                                    @guest
                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ __('Login') }} {{ __('to add a comment.') }}</span>
                                    @endguest
                                </div>

                                @if ($comment->replies->isNotEmpty())
                                    <div class="mt-4 space-y-3 border-l-2 border-gray-200 dark:border-slate-700 pl-4">
                                        @foreach ($comment->replies as $reply)
                                            <div class="bg-white dark:bg-slate-800 rounded-md p-3 border border-gray-200 dark:border-slate-700">
                                                <div class="flex items-center justify-between mb-1">
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $reply->author }}</p>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $reply->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-sm text-gray-700 dark:text-gray-200">{{ $reply->content }}</p>
                                                @auth
                                                    <form method="POST" action="{{ route('comments.like', $reply) }}" class="mt-2">
                                                        @csrf
                                                        <button type="submit" class="text-xs text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 flex items-center gap-1">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                                            </svg>
                                                            <span>{{ $reply->likes_count }}</span>
                                                        </button>
                                                    </form>
                                                @endauth
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400">{{ __('No comments yet. Be the first to comment on this article!') }}</p>
                    </div>
                @endforelse
            </div>

            <!-- Load More Comments -->
            <div class="mt-8 text-center">
                <button class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                    {{ __('Load more comments') }}
                </button>
            </div>
        </section>

        <!-- Related Posts -->
        <section class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ __('Related posts') }}</h2>
            <div class="grid gap-6 md:grid-cols-3">
                @forelse ($relatedPosts as $relatedPost)
                    <a href="{{ route('posts.show', $relatedPost->slug) }}" class="group">
                        <article
                            class="bg-white dark:bg-slate-800 rounded-lg shadow-md dark:shadow-lg hover:shadow-xl dark:hover:shadow-2xl transition-shadow duration-300 overflow-hidden">
                            <div
                                class="h-32 bg-linear-to-br from-indigo-500 to-purple-600 dark:from-indigo-600 dark:to-purple-700 flex items-center justify-center overflow-hidden">
                                @if ($relatedPost->photo)
                                    <img src="{{ asset('storage/' . $relatedPost->photo) }}" alt="{{ $relatedPost->title }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-5xl">📝</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 dark:text-gray-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 line-clamp-2 mb-2 transition-colors">
                                    {{ $relatedPost->title }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ ceil(str_word_count(strip_tags($relatedPost->content)) / 200) }} {{ __('min read') }}
                                </p>
                            </div>
                        </article>
                    </a>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500 dark:text-gray-400">
                        <p>{{ __('No related posts') }}</p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

</x-layout>
