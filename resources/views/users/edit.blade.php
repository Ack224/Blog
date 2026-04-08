<x-layout>
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <section class="bg-white dark:bg-slate-800 rounded-lg shadow-md dark:shadow-lg p-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Account settings') }}</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Edit your profile and special links visible on your author page.') }}
            </p>

            <form method="POST" action="{{ route('users.update') }}" class="mt-6 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Name') }}</label>
                    <input id="name" name="name" type="text" required value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white" />
                    @error('name')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Bio') }}</label>
                    <textarea id="bio" name="bio" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="website_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Website') }}</label>
                        <input id="website_url" name="website_url" type="url" value="{{ old('website_url', $user->website_url) }}"
                            placeholder="https://twojastrona.pl"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white" />
                        @error('website_url')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="github_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">GitHub</label>
                        <input id="github_url" name="github_url" type="url" value="{{ old('github_url', $user->github_url) }}"
                            placeholder="https://github.com/twoj-login"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white" />
                        @error('github_url')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="x_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('X / Twitter') }}</label>
                        <input id="x_url" name="x_url" type="url" value="{{ old('x_url', $user->x_url) }}"
                            placeholder="https://x.com/twoj-login"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white" />
                        @error('x_url')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="locale" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Language') }}</label>
                        <select id="locale" name="locale"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                            <option value="pl" @selected(old('locale', $user->locale ?? 'pl') === 'pl')>{{ __('Polish') }}</option>
                            <option value="en" @selected(old('locale', $user->locale ?? 'pl') === 'en')>English</option>
                        </select>
                        @error('locale')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="theme" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Theme') }}</label>
                        <select id="theme" name="theme"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white">
                            <option value="light" @selected(old('theme', $user->theme ?? 'light') === 'light')>{{ __('Light') }}</option>
                            <option value="dark" @selected(old('theme', $user->theme ?? 'light') === 'dark')>{{ __('Dark') }}</option>
                        </select>
                        @error('theme')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors">
                        {{ __('Save changes') }}
                    </button>
                </div>
            </form>
        </section>
    </main>
</x-layout>
