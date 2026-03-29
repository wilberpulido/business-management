<section id="login" class="relative min-h-screen flex items-center justify-center">
    <form
        method="POST"
        action="{{ route('login') }}"
        class="w-full min-h-screen sm:min-h-0 sm:max-w-md bg-white dark:bg-slate-900 p-6 sm:p-10 sm:rounded-3xl shadow-2xl flex flex-col justify-center space-y-6">
        @csrf

        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
            {{ __('ui.auth.login') }}
        </h2>

        <div class="space-y-4">
            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    {{ __('ui.auth.email') }}
                </label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    placeholder="email@example.com"
                    class="block w-full rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition duration-150 ease-in-out sm:text-sm shadow-sm"
                />
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    {{ __('ui.auth.password') }}
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="block w-full rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition duration-150 ease-in-out sm:text-sm shadow-sm"
                />
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Remember me + Forgot password --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between pt-2">
            <label class="inline-flex items-center cursor-pointer">
                <input
                    type="checkbox"
                    name="remember"
                    class="w-5 h-5 rounded border-gray-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500"
                />
                <span class="ml-3 text-sm text-gray-600 dark:text-gray-400 font-medium">
                    {{ __('ui.auth.remember_me') }}
                </span>
            </label>

            <a href="{{ route('password.request') }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                {{ __('ui.auth.forgot_password') }}
            </a>
        </div>

        <x-ui.button size="lg" class="w-full">
            {{ __('ui.buttons.login') }}
        </x-ui.button>

        <p class="text-center text-sm text-gray-600 dark:text-gray-400">
            {{ __('ui.auth.no_account') }}
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                {{ __('ui.auth.register') }}
            </a>
        </p>
    </form>
</section>
