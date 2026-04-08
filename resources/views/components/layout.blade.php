@props([
    'title' => 'Blog - Lista Postow',
    'description' => 'Nowoczesny blog o programowaniu, Laravel i web development.',
    'canonical' => null,
    'ogType' => 'website',
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full" data-default-theme="{{ auth()->check() ? (auth()->user()->theme ?? 'light') : 'light' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $canonical ?? url()->current() }}">

    <meta property="og:site_name" content="Blog">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $canonical ?? url()->current() }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $description }}">

    <script>
        (function () {
            var root = document.documentElement;
            var defaultTheme = root.dataset.defaultTheme || 'light';
            var savedTheme = localStorage.getItem('theme');
            var theme = savedTheme || defaultTheme;

            if (theme === 'dark') {
                root.classList.add('dark');
            } else {
                root.classList.remove('dark');
            }
        })();
    </script>
    <script>
        (function () {
            function applyTheme(theme) {
                var resolvedTheme = theme === 'dark' ? 'dark' : 'light';
                document.documentElement.classList.toggle('dark', resolvedTheme === 'dark');
                localStorage.setItem('theme', resolvedTheme);
                return resolvedTheme;
            }

            function toggleTheme() {
                var isDark = document.documentElement.classList.contains('dark');
                return applyTheme(isDark ? 'light' : 'dark');
            }

            window.themeManager = window.themeManager || {
                apply: applyTheme,
                toggle: toggleTheme,
                current: function () {
                    return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
                },
            };
        })();
    </script>

    @vite(['resources/css/app.css'])
</head>

<body class="h-full bg-gray-50 text-gray-900 dark:bg-slate-950 dark:text-gray-100 transition-colors duration-200">
    @include('partials.navigation')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 space-y-3">
        @if (session('success'))
            <div class="rounded-md bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-md bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 text-sm">
                {{ session('error') }}
            </div>
        @endif
    </div>

    {{ $slot }}

    @include('partials.footer')

    @vite(['resources/js/app.js'])
</body>

</html>
