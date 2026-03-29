<section id="forgot-password" class="relative min-h-screen flex items-center justify-center">
    <div class="w-full min-h-screen sm:min-h-0 sm:max-w-md bg-white dark:bg-slate-900 p-6 sm:p-10 sm:rounded-3xl shadow-2xl flex flex-col justify-center space-y-6">

        <div>
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                {{ __('ui.auth.reset_password') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                {{ __('ui.auth.reset_password_instructions') }}
            </p>
        </div>

        @if (session('status'))
            <x-ui.alert type="info" :dismissible="false">{{ session('status') }}</x-ui.alert>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

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

            <x-ui.button size="lg" class="w-full">
                {{ __('ui.auth.send_reset_link') }}
            </x-ui.button>
        </form>

        <p class="text-center text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                {{ __('ui.auth.back_to_login') }}
            </a>
        </p>

    </div>
</section>
