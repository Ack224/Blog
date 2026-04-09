<x-layout :title="__('Kontakt')">
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 dark:text-white mb-4">
                    {{ __('Porozmawiajmy') }}
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-xl mx-auto">
                    {{ __('Jesteśmy zawsze otwarci na omawianie nowych projektów, kreatywnych pomysłów i wizji. Skontaktuj się z nami jedną z poniższych dróg.') }}
                </p>
            </div>

            <div class="space-y-6">
                <!-- Email Block -->
                <div class="p-6 md:p-8 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col md:flex-row md:items-center gap-6">
                    <div class="shrink-0 w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Adres E-mail') }}</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1 mb-3">{{ __('Odpowiadamy zazwyczaj w ciągu kilku godzin w dni robocze.') }}</p>
                        <a href="mailto:hello@example.com" class="text-indigo-600 dark:text-indigo-400 font-medium hover:underline">jakub4145@gmail.com</a>
                    </div>
                </div>

                <!-- Social Block -->
                 <div class="p-6 md:p-8 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col md:flex-row gap-6">
                    <div class="shrink-0 w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"></path></svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Sieci Społecznościowe') }}</h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1 mb-4">{{ __('Znajdź nas online, by zadać szybkie pytanie.') }}</p>
                        <div class="flex flex-wrap gap-4">
                            <a href="https://github.com/Ack224" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">GitHub</a>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    {{ __('Powrót na stronę główną') }}
                </a>
            </div>
        </div>
    </div>
</x-layout>
