<x-layout>
    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Column -->
            <div class="lg:col-span-2">

                <!-- Post Header -->
                <article class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                    <!-- Featured Image -->
                    <div class="h-96 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <span class="text-9xl">{{ $post->photo ?? '📝' }}</span>
                    </div>

                    <!-- Post Content -->
                    <div class="p-8">
                        <!-- Meta Info -->
                        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                            <div class="flex items-center gap-3">
                                <!-- Author Avatar with Gradient -->
                                @if ($post->user)
                                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-400 via-purple-400 to-pink-400 rounded-full flex items-center justify-center text-white text-lg font-bold shadow-md">
                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $post->user->name)[1] ?? '', 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $post->user->name }}</p>
                                        <p class="text-sm text-gray-500">Opublikowano: {{ $post->created_at->format('d F Y') }}</p>
                                    </div>
                                @else
                                    <div class="w-14 h-14 bg-gray-300 rounded-full flex items-center justify-center text-white text-lg font-bold">
                                        {{ strtoupper(substr($post->author, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $post->author }}</p>
                                        <p class="text-sm text-gray-500">Opublikowano: {{ $post->created_at->format('d F Y') }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-auto flex gap-2 items-center">
                                @if ($post->is_published)
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                        Opublikowany
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                                        Szkic
                                    </span>
                                @endif
                                <div class="flex gap-2">
                                    @auth
                                        @if (Gate::allows('update-post', $post))
                                            <a href="{{ route('posts.edit', $post->id) }}" class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full hover:bg-blue-200 transition">
                                                ✏️ Edytuj
                                            </a>
                                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}" style="display: inline" onsubmit="return confirm('Czy na pewno chcesz usunąć ten post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full hover:bg-red-200 transition">
                                                    🗑️ Usuń
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>

                        <!-- Title -->
                        <h1 class="text-4xl font-bold text-gray-900 mb-4">
                            {{ $post->title }}
                        </h1>

                        @if ($post->lead)
                            <!-- Lead -->
                            <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                                {{ $post->lead }}
                            </p>
                        @endif

                        <!-- Content -->
                        <div class="prose prose-lg max-w-none">
                            <p class="text-gray-700 mb-4 leading-relaxed whitespace-pre-line">
                                {!! $post->content !!}
                            </p>
                        </div>

                        <!-- Tags -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-3">Tagi:</p>
                            <div class="flex flex-wrap gap-2">
                                @forelse ($post->tags as $tag)
                                    <a href="{{ route('posts.index', ['search' => $tag->name]) }}"
                                        class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full hover:bg-gray-200 cursor-pointer transition">
                                        #{{ $tag->name }}
                                    </a>
                                @empty
                                    <p class="text-sm text-gray-500">Brak tagów</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Social Share -->
                        <div class="mt-6 flex items-center gap-4">
                            <span class="text-sm text-gray-600">Udostępnij:</span>
                            <button class="text-blue-600 hover:text-blue-700">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </button>
                            <button class="text-sky-500 hover:text-sky-600">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417a9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Comments Section -->
                <section class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        Komentarze ({{ $post->comments->count() }})
                    </h2>

                    <!-- Comment Form - Only for Logged-in Users -->
                    <div class="mb-8 pb-8 border-b border-gray-200">
                        @auth
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Dodaj komentarz</h3>
                            <form method="POST" action="{{ route('comments.store', $post->id) }}" class="space-y-4">
                                @csrf
                                <!-- Author (auto-populated) -->
                                <div>
                                    <label for="author" class="block text-sm font-medium text-gray-700 mb-2">
                                        Twoje imię
                                    </label>
                                    <input type="text" id="author" name="author"
                                        value="{{ auth()->user()->name }}" readonly
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-700">
                                </div>

                                <!-- Email (auto-populated) -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email
                                    </label>
                                    <input type="email" id="email" name="email"
                                        value="{{ auth()->user()->email }}" readonly
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 text-gray-700">
                                    <p class="mt-1 text-sm text-gray-500">Email nie będzie publikowany</p>
                                </div>

                                <!-- Comment Content -->
                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                        Komentarz *
                                    </label>
                                    <textarea id="content" name="content" required rows="5"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"
                                        placeholder="Podziel się swoimi przemyśleniami..."></textarea>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex items-center gap-4">
                                    <button type="submit"
                                        class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                                        Opublikuj komentarz
                                    </button>
                                </div>
                            </form>
                        @else
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                                <p class="text-gray-700 mb-4">Aby dodać komentarz, musisz być zalogowany.</p>
                                <a href="{{ route('login') }}" class="inline-block bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                                    Zaloguj się
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Comments List -->
                    <div class="space-y-6">
                        @forelse ($comments as $comment)
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <!-- Comment Avatar -->
                                    @if ($comment->user)
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-cyan-500 rounded-full flex items-center justify-center text-white font-semibold shadow-sm">
                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $comment->user->name)[1] ?? '', 0, 1)) }}
                                        </div>
                                    @else
                                        <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center text-white font-semibold shadow-sm">
                                            {{ strtoupper(substr($comment->author, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-semibold text-gray-900">
                                                @if ($comment->user)
                                                    {{ $comment->user->name }}
                                                @else
                                                    {{ $comment->author }}
                                                @endif
                                            </h4>
                                            <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-700 leading-relaxed">
                                            {{ $comment->content }}
                                        </p>
                                        <div class="mt-3 flex items-center gap-4">
                                            <a href="#reply-{{ $comment->id }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                                                Odpowiedz
                                            </a>
                                            <form method="POST" action="{{ route('comments.like', [$post->id, $comment->id]) }}" style="display: inline">
                                                @csrf
                                                <button type="submit" class="text-sm text-gray-500 hover:text-red-500 flex items-center gap-1 transition-colors">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                                    </svg>
                                                    <span>{{ $comment->likes_count ?? 0 }}</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Replies -->
                                    @if ($comment->replies->count() > 0)
                                        <div class="mt-4 ml-4 pl-4 border-l-2 border-gray-300 space-y-4">
                                            @foreach ($comment->replies as $reply)
                                                <div class="flex gap-4">
                                                    <div class="flex-shrink-0">
                                                        <!-- Reply Avatar -->
                                                        @if ($reply->user)
                                                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-sm">
                                                                {{ strtoupper(substr($reply->user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $reply->user->name)[1] ?? '', 0, 1)) }}
                                                            </div>
                                                        @else
                                                            <div class="w-10 h-10 bg-gray-400 rounded-full flex items-center justify-center text-white text-sm font-semibold shadow-sm">
                                                                {{ strtoupper(substr($reply->author, 0, 2)) }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="bg-white rounded-lg p-3 border border-gray-200">
                                                            <div class="flex items-center justify-between mb-2">
                                                                <h5 class="font-semibold text-gray-900 text-sm">
                                                                    @if ($reply->user)
                                                                        {{ $reply->user->name }}
                                                                    @else
                                                                        {{ $reply->author }}
                                                                    @endif
                                                                </h5>
                                                                <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            <p class="text-gray-700 leading-relaxed text-sm">
                                                                {{ $reply->content }}
                                                            </p>
                                                            <div class="mt-2 flex items-center gap-2">
                                                                <form method="POST" action="{{ route('comments.like', [$post->id, $reply->id]) }}" style="display: inline">
                                                                    @csrf
                                                                    <button type="submit" class="text-xs text-gray-500 hover:text-red-500 flex items-center gap-1 transition-colors">
                                                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                                                    </svg>
                                                                        <span>{{ $reply->likes_count ?? 0 }}</span>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Reply Form -->
                                    <details class="mt-4">
                                        <summary class="text-sm text-indigo-600 hover:text-indigo-700 font-medium cursor-pointer">
                                            ➕ Dodaj odpowiedź
                                        </summary>
                                        <form method="POST" action="{{ route('comments.reply', [$post->id, $comment->id]) }}" class="mt-4 space-y-3 bg-gray-50 p-4 rounded-lg" id="reply-{{ $comment->id }}">
                                            @csrf
                                            @auth
                                                <!-- Auto-populated fields for logged-in users -->
                                                <input type="text" name="author"
                                                    value="{{ auth()->user()->name }}" readonly
                                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded bg-gray-100 text-gray-700">
                                                <input type="email" name="email"
                                                    value="{{ auth()->user()->email }}" readonly
                                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded bg-gray-100 text-gray-700">
                                            @else
                                                <!-- Input fields for anonymous users -->
                                                <input type="text" name="author" placeholder="Twoje imię" required
                                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                                <input type="email" name="email" placeholder="Email" required
                                                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                                            @endauth
                                            <textarea name="content" placeholder="Twoja odpowiedź..." required rows="3"
                                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"></textarea>
                                            <button type="submit" class="bg-indigo-600 text-white text-sm px-4 py-2 rounded font-medium hover:bg-indigo-700 transition-colors">
                                                Opublikuj odpowiedź
                                            </button>
                                        </form>
                                    </details>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500">Brak komentarzy. Bądź pierwszy, który skomentuje ten artykuł!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $comments->links('pagination::tailwind') }}
                    </div>
                </section>

                <!-- Related Posts -->
                <section class="mt-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Powiązane artykuły</h2>
                    <div class="grid gap-6 md:grid-cols-3">
                        @forelse ($relatedPosts as $relatedPost)
                            <a href="{{ route('posts.show', $relatedPost->slug) }}" class="group">
                                <article
                                    class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                                    <div
                                        class="h-32 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                        <span class="text-5xl">{{ $relatedPost->photo ?? '📝' }}</span>
                                    </div>
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 group-hover:text-indigo-600 line-clamp-2 mb-2">
                                            {{ $relatedPost->title }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            {{ ceil(str_word_count(strip_tags($relatedPost->content)) / 200) }} min czytania
                                        </p>
                                    </div>
                                </article>
                            </a>
                        @empty
                            <div class="col-span-full text-center py-8 text-gray-500">
                                <p>Brak powiązanych artykułów</p>
                            </div>
                        @endforelse
                    </div>
                </section>

            </div>

            <!-- Sidebar - Author Card -->
            <aside class="lg:col-span-1">
                <!-- Author Card -->
                @if ($post->user)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-8">
                        <!-- Background Gradient -->
                        <div class="h-24 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                        <!-- Author Info -->
                        <div class="px-6 pb-6">
                            <!-- Avatar -->
                            <div class="flex justify-center -mt-12 mb-4">
                                <div class="w-24 h-24 bg-gradient-to-br from-indigo-400 via-purple-400 to-pink-500 rounded-full flex items-center justify-center text-white text-4xl font-bold border-4 border-white shadow-lg">
                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $post->user->name)[1] ?? '', 0, 1)) }}
                                </div>
                            </div>

                            <!-- Author Name -->
                            <h3 class="text-xl font-bold text-gray-900 text-center mb-2">
                                {{ $post->user->name }}
                            </h3>

                            <!-- Author Profile Link -->
                            <a href="{{ route('author.show', $post->user->id) }}" class="block text-center text-indigo-600 hover:text-indigo-700 text-sm font-medium mb-4">
                                Pokaż profil autora
                            </a>

                            <!-- Follower Count -->
                            <div class="text-center mb-4 py-3 border-y border-gray-200">
                                <p class="text-2xl font-bold text-gray-900">0</p>
                                <p class="text-sm text-gray-500">Obserwujących</p>
                            </div>

                            <!-- Follow Button (only for non-authors) -->
                            @auth
                                @if (auth()->user()->id !== $post->user->id)
                                    <button class="w-full bg-indigo-600 text-white py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                                        Obserwuj
                                    </button>
                                @endif
                            @else
                                <button class="w-full bg-gray-200 text-gray-700 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors cursor-not-allowed" disabled>
                                    Zaloguj się, aby obserwować
                                </button>
                            @endauth
                        </div>
                    </div>
                @endif

                <!-- Related Tags Section -->
                @if ($post->tags->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6 mt-8">
                        <h4 class="text-lg font-bold text-gray-900 mb-4">Popularne tagi</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($post->tags as $tag)
                                <a href="{{ route('posts.index', ['search' => $tag->name]) }}"
                                    class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs rounded-full hover:bg-indigo-200 transition">
                                    #{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </aside>

        </div>

    </main>

</x-layout>
