<x-layout>
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="flex flex-col max-w-3xl mx-auto my-4 bg-white dark:bg-slate-800 rounded-lg shadow-md p-6 gap-2">
        @csrf

        @if ($errors->any())
            <ul class="bg-red-200 text-red-700 p-6 mb-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Tytul</label>
        <input type="text" name="title" value="{{ old('title') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100" />
        @error('title')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Przyjazny adres</label>
        <input type="text" name="slug" value="{{ old('slug') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100" />
        @error('slug')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Zajawka</label>
        <textarea name="lead" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100">{{ old('lead') }}</textarea>
        @error('lead')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Treść</label>
        <textarea name="content" rows="8" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100">{{ old('content') }}</textarea>
        @error('content')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Kategoria</label>
        <select name="category" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100">
            <option value="">Wybierz kategorie</option>
            <option value="Laravel" @selected(old('category') === 'Laravel')>Laravel</option>
            <option value="React" @selected(old('category') === 'React')>React</option>
            <option value="AI & Copilot" @selected(old('category') === 'AI & Copilot')>AI & Copilot</option>
        </select>
        @error('category')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Wlasna kategoria (opcjonalnie)</label>
        <input type="text" name="custom_category" value="{{ old('custom_category') }}" placeholder="np. DevOps"
            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100" />
        @error('custom_category')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Zdjecie posta</label>
        <input type="file" name="photo" accept="image/*" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-gray-100" />
        @error('photo')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label class="inline-flex items-center gap-2 mt-3 text-gray-700 dark:text-gray-300">
            <input type="checkbox" name="is_published" value="1" @checked(old('is_published', true))>
            <span>Opublikuj od razu</span>
        </label>

        <button type="submit" class="bg-blue-700 text-white p-4 mt-4">Dodaj</button>
    </form>
</x-layout>
