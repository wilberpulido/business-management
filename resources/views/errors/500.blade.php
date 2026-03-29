<x-layouts.guest>
    <section class="relative min-h-screen flex items-center justify-center px-4">
        <x-ui.background-blobs />
        <div class="text-center">
            <p class="text-8xl font-extrabold text-indigo-600 dark:text-indigo-400">500</p>
            <h1 class="mt-4 text-3xl font-bold text-slate-900 dark:text-white tracking-tight sm:text-5xl">
                {{ __('ui.errors.500_title') }}
            </h1>
            <p class="mt-4 text-base text-gray-500 dark:text-slate-400">
                {{ __('ui.errors.500_message') }}
            </p>
            <div class="mt-8">
                <x-ui.button href="/" size="lg" wire:navigate>
                    {{ __('ui.errors.home') }}
                </x-ui.button>
            </div>
        </div>
    </section>
</x-layouts.guest>
