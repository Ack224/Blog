<x-layout :title="__('Home')">
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <!-- Hero Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 md:p-16 text-center">
                    <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-6">
                        {{ __('Witaj na naszym Blogu') }}
                    </h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
                        {{ __('Przeglądaj najnowsze artykuły, sprawdzaj co cieszy się największą popularnością w tym tygodniu i dołącz do dyskusji.') }}
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('blog.index') }}" class="inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-semibold rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                            {{ __('Przejdź do Bloga') }}
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex justify-center items-center px-8 py-3 border border-gray-300 dark:border-gray-600 text-base font-semibold rounded-lg shadow-sm text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            {{ __('Kontakt') }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Top Posts Section -->
            <div>
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ __('Top 3 wpisy tego tygodnia') }}
                    </h2>
                    <a href="{{ route('blog.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                        {{ __('Zobacz wszystkie') }} &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($weeklyTopPosts as $post)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                            @if ($post->photo)
                                <img src="{{ asset('storage/' . $post->photo) }}" alt="{{ $post->title }}" class="w-full h-52 object-cover">
                            @else
                                <div class="w-full h-52 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                </div>
                            @endif
                            
                            <div class="p-6 flex-1 flex flex-col">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                        {{ $post->created_at->format('d.m.Y') }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                        {{ $post->weekly_likes_count }}
                                    </span>
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 leading-tight">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-6 line-clamp-3">
                                    {{ $post->lead ?? \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                                </p>
                                
                                <div class="mt-auto flex items-center pt-4 border-t border-gray-100 dark:border-gray-700/60">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-sm font-bold text-gray-600 dark:text-gray-300">
                                        {{ substr($post->user->name ?? 'A', 0, 1) }}
                                    </div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-200">
                                        {{ $post->user->name ?? 'Autor' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                            <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Brak popularnych postów') }}</h3>
                            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ __('Jeszcze nikt nie polubił żadnego wpisu w tym tygodniu. Bądź pierwszą osobą!') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
        </div>
    </div>
</x-layout>
