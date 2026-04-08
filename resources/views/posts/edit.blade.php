<x-layout>
    <div class="max-w-3xl mx-auto my-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Edytuj post</h1>

        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" class="bg-white dark:bg-slate-800 rounded-lg shadow-md dark:shadow-lg p-8">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <p class="font-semibold mb-2">Błędy walidacji:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tytuł *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('title')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Przyjazny adres (slug) *</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $post->slug) }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('slug')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Autor *</label>
                    <input type="text" id="author" name="author" value="{{ old('author', $post->author) }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('author')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategoria</label>
                    <select id="category" name="category"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <option value="">Wybierz kategorię</option>
                        <option value="Laravel" {{ old('category', $post->category) === 'Laravel' ? 'selected' : '' }}>Laravel</option>
                        <option value="React" {{ old('category', $post->category) === 'React' ? 'selected' : '' }}>React</option>
                        <option value="AI & Copilot" {{ old('category', $post->category) === 'AI & Copilot' ? 'selected' : '' }}>AI & Copilot</option>
                    </select>
                </div>

                <div>
                    <label for="custom_category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Wlasna kategoria (opcjonalnie)</label>
                    <input type="text" id="custom_category" name="custom_category" value="{{ old('custom_category') }}" placeholder="np. DevOps"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @error('custom_category')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="lead" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Zajawka (podsumowanie)</label>
                    <textarea id="lead" name="lead" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none">{{ old('lead', $post->lead) }}</textarea>
                    @error('lead')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Treść *</label>
                    <textarea id="content" name="content" rows="10" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none">{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Zdjecie posta</label>
                    <input type="file" id="photo" name="photo" accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    @if ($post->photo)
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Obecne zdjecie zostanie zachowane, jesli nie wybierzesz nowego pliku.</p>
                    @endif
                    @error('photo')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published))>
                        <span>Post opublikowany</span>
                    </label>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                        Aktualizuj post
                    </button>
                    <a href="{{ route('posts.show', $post->slug) }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-400 transition-colors">
                        Anuluj
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-layout>
