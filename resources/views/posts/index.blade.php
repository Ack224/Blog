<x-layout
    :title="__('Blog - Latest Posts')"
    :description="__('Browse the latest articles about programming, Laravel, and web development.')"
    :canonical="route('blog.index', request()->query())"
>
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white transition-colors">{{ __('Latest Posts') }}</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400 transition-colors">{{ __('Discover the latest articles from the programming world.') }}</p>
        </div>

        <form method="GET" action="{{ route('blog.index') }}"
            class="mb-8 p-4 bg-white dark:bg-slate-800 rounded-lg shadow-md dark:shadow-lg grid gap-4 lg:grid-cols-4">
            <div class="lg:col-span-2">
                <label for="q" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Search') }}</label>
                <input id="q" name="q" type="text" value="{{ $filters['q'] }}" placeholder="{{ __('Title, lead or content') }}"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-slate-700 rounded-md bg-white dark:bg-slate-900 text-gray-900 dark:text-white" />
            </div>

            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Category') }}</label>
                <select id="category" name="category"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-slate-700 rounded-md bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                    <option value="">{{ __('All') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected($filters['category'] === $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="tag" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tag</label>
                <select id="tag" name="tag"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-slate-700 rounded-md bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                    <option value="">{{ __('All') }}</option>
                    @foreach ($tags as $tag)
                        <option value="{{ $tag->slug }}" @selected($filters['tag'] === $tag->slug)>#{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-4 flex items-center gap-3">
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700 transition-colors">
                    {{ __('Filter') }}
                </button>
                <a href="{{ route('blog.index') }}"
                    class="px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-200 rounded-md text-sm font-medium hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
                    {{ __('Clear') }}
                </a>
            </div>
        </form>

        <!-- Posts Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <article
                    class="bg-white dark:bg-slate-800 rounded-lg shadow-md dark:shadow-lg hover:shadow-xl dark:hover:shadow-2xl transition-all duration-300 overflow-hidden group cursor-pointer"
                    data-card-url="{{ route('posts.show', $post->slug) }}"
                    tabindex="0"
                >
                    <!-- Image/Thumbnail -->
                    <div class="h-48 bg-linear-to-br from-indigo-500 to-purple-600 dark:from-indigo-600 dark:to-purple-700 flex items-center justify-center relative overflow-hidden">
                        @if ($post->photo)
                            <img src="{{ asset('storage/' . $post->photo) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-6xl">📝</span>
                        @endif

                        <!-- Action buttons overlay -->
                        @can('update-post', $post)
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                                <a href="{{ route('posts.edit', $post) }}" class="bg-white text-indigo-600 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-gray-100 transition-colors">
                                    {{ __('Edit') }}
                                </a>
                                <form method="POST" action="{{ route('posts.destroy', $post) }}" onclick="return confirm('{{ __('Are you sure you want to delete this post?') }}');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <!-- Status badge -->
                        <div class="flex items-center gap-2 mb-3">
                            @if ($post->is_published)
                                <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-semibold rounded-full transition-colors">
                                    {{ __('Published') }}
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-gray-300 text-xs font-semibold rounded-full transition-colors">
                                    {{ __('Draft') }}
                                </span>
                            @endif
                        </div>

                        <!-- Title -->
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>

                        <!-- Preview -->
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3 transition-colors">
                            {{ $post->lead ?? Str::limit(strip_tags($post->content), 150) }}
                        </p>

                        <div class="mb-4 flex items-center gap-3 text-xs text-gray-500 dark:text-gray-400">
                            <span>❤ {{ $post->liked_by_users_count }}</span>
                            <span>🔖 {{ $post->bookmarked_by_count }}</span>
                        </div>

                        <div class="flex items-center gap-2 mb-4 flex-wrap">
                            @if ($post->category)
                                <a href="{{ route('blog.index', array_merge(request()->query(), ['category' => $post->category])) }}"
                                    class="px-2 py-1 text-xs rounded bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-colors">
                                    {{ $post->category }}
                                </a>
                            @endif
                            @foreach ($post->tags->take(3) as $tag)
                                <a href="{{ route('blog.index', array_merge(request()->query(), ['tag' => $tag->slug])) }}"
                                    class="px-2 py-1 text-xs rounded bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>

                        <!-- Author info -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-slate-700 transition-colors">
                            <div class="flex items-center gap-2">
                                @if($post->user)
                                    <div class="w-8 h-8 bg-indigo-500 dark:bg-indigo-600 rounded-full flex items-center justify-center text-xs font-semibold text-white">
                                        {{ strtoupper(substr($post->user->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <a href="{{ route('users.show', $post->user) }}" class="text-sm text-gray-700 dark:text-gray-300 font-medium hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                        {{ $post->user->name }}
                                    </a>
                                @else
                                    <div class="w-8 h-8 bg-gray-300 dark:bg-slate-700 rounded-full flex items-center justify-center text-sm font-semibold">
                                        {{ strtoupper(substr($post->author ?? 'A', 0, 1)) }}
                                    </div>
                                    <span class="text-sm text-gray-700 dark:text-gray-300 font-medium">{{ $post->author ?? __('Unknown') }}</span>
                                @endif
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-500 transition-colors">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400 text-lg transition-colors">{{ __('No posts available.') }}</p>
                    @auth
                        <a href="{{ route('posts.create') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium mt-2 inline-block transition-colors">
                            {{ __('Create your first post') }}
                        </a>
                    @else
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-2 transition-colors">
                            <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-medium transition-colors">{{ __('Login') }}</a> {{ __('to create a post') }}
                        </p>
                    @endauth
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    </main>
</x-layout>
