<section id="reset-password" class="relative min-h-screen flex items-center justify-center">
    <form
        method="POST"
        action="{{ route('password.update') }}"
        class="w-full min-h-screen sm:min-h-0 sm:max-w-md bg-white dark:bg-slate-900 p-6 sm:p-10 sm:rounded-3xl shadow-2xl flex flex-col justify-center space-y-6">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}" />

        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
            {{ __('ui.auth.reset_password') }}
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
                    value="{{ old('email', $request->email) }}"
                    autocomplete="email"
                    class="block w-full rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition duration-150 ease-in-out sm:text-sm shadow-sm"
                />
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- New Password --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    {{ __('ui.auth.new_password') }}
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    placeholder="••••••••"
                    class="block w-full rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition duration-150 ease-in-out sm:text-sm shadow-sm"
                />
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    {{ __('ui.auth.confirm_password') }}
                </label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    placeholder="••••••••"
                    class="block w-full rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition duration-150 ease-in-out sm:text-sm shadow-sm"
                />
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <x-ui.button size="lg" class="w-full">
            {{ __('ui.auth.reset_password') }}
        </x-ui.button>

    </form>
</section>
