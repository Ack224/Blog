<x-layout>
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Najnowsze Posty</h2>
            <p class="mt-2 text-gray-600">Odkryj najnowsze artykuły z świata programowania</p>
        </div>
        <!-- Filters/Search Bar -->
        <form method="GET" action="{{ route('posts.index') }}" class="mb-6 flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Szukaj postów..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            >
            </div>

            <select
            name="category"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
            >
            <option value="">Wszystkie kategorie</option>
            <option value="Laravel" {{ request('category') === 'Laravel' ? 'selected' : '' }}>Laravel</option>
            <option value="React" {{ request('category') === 'React' ? 'selected' : '' }}>React</option>
            <option value="AI & Copilot" {{ request('category') === 'AI & Copilot' ? 'selected' : '' }}>AI & Copilot</option>
            </select>

            <button
            type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700"
            >
            Filtruj
            </button>
        </form>

        <!-- Posts Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

            @forelse ($posts as $post)
                <article
                    class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <span class="text-6xl">{{ $post->photo ?? '📝' }}</span>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            @if ($post->is_published)
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    Opublikowany
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                                    Szkic
                                </span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 hover:text-indigo-600 cursor-pointer">
                            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ $post->lead ?? Str::limit(strip_tags($post->content), 150) }}
                        </p>
                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-sm font-semibold">
                                    {{ strtoupper(substr($post->author, 0, 2)) }}
                                </div>
                                <span class="text-sm text-gray-700 font-medium">{{ $post->author }}</span>
                            </div>
                            <span class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex gap-2 mt-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('posts.edit', $post->id) }}" class="flex-1 text-center px-2 py-1 bg-blue-50 text-blue-600 text-xs font-semibold rounded hover:bg-blue-100 transition">
                                ✏️ Edytuj
                            </a>
                            <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="flex-1" onsubmit="return confirm('Czy na pewno?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-2 py-1 bg-red-50 text-red-600 text-xs font-semibold rounded hover:bg-red-100 transition">
                                    🗑️ Usuń
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Brak postów do wyświetlenia.</p>
                    <a href="/posts/create" class="text-indigo-600 hover:text-indigo-700 font-medium mt-2 inline-block">
                        Dodaj pierwszy post
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center">
            {{ $posts->links('pagination::tailwind') }}
        </div>
    </main>
</x-layout>