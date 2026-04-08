    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid gap-8 md:grid-cols-2 md:items-start">
                <div>
                    <h3 class="text-lg font-semibold">{{ __('Stay in the loop') }}</h3>
                    <p class="mt-2 text-sm text-gray-300">{{ __('Get a monthly digest with the best posts and updates.') }}</p>
                </div>

                <div>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex flex-col gap-3 sm:flex-row">
                        @csrf
                        <label for="newsletter_email" class="sr-only">{{ __('Email address') }}</label>
                        <input
                            id="newsletter_email"
                            name="newsletter_email"
                            type="email"
                            value="{{ old('newsletter_email') }}"
                            placeholder="{{ __('Email address') }}"
                            required
                            class="w-full rounded-md border border-gray-600 bg-gray-900 px-4 py-2 text-sm text-white placeholder:text-gray-400 focus:border-indigo-400 focus:outline-none"
                        >
                        <button
                            type="submit"
                            class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500"
                        >
                            {{ __('Subscribe') }}
                        </button>
                    </form>

                    @error('newsletter_email')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 border-t border-gray-700 pt-6 text-center">
                <p class="text-gray-400">© 2026 ZSTiO. {{ __('Educational project - Laravel foundations') }}</p>
            </div>
        </div>
    </footer>
