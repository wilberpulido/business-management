@props([
    'maxWidth' => 'md',
])

@php
$widths = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
];

$widthClass = $widths[$maxWidth] ?? $widths['md'];
@endphp

<div x-data="{ open: false }" {{ $attributes }}>
    {{-- Trigger --}}
    @isset($trigger)
        <div @click="open = true">{{ $trigger }}</div>
    @endisset

    {{-- Backdrop + Panel --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @keydown.escape.window="open = false"
    >
        {{-- Backdrop --}}
        <div
            class="absolute inset-0 bg-black/50 dark:bg-black/70"
            @click="open = false"
        ></div>

        {{-- Panel --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full {{ $widthClass }} bg-white dark:bg-slate-900 rounded-2xl shadow-xl"
        >
            {{-- Header --}}
            @isset($header)
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-slate-800">
                    <div class="text-base font-semibold text-slate-900 dark:text-white">
                        {{ $header }}
                    </div>
                    <button
                        type="button"
                        @click="open = false"
                        class="text-gray-400 hover:text-gray-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors"
                    >
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endisset

            {{-- Body --}}
            <div class="px-6 py-4">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            @isset($footer)
                <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-800 flex justify-end gap-3">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
