@props([
    'type' => 'info',
    'dismissible' => true,
])

@php
$styles = [
    'success' => [
        'wrapper' => 'bg-green-50 border-green-200 dark:bg-green-950 dark:border-green-800',
        'icon'    => 'text-green-500 dark:text-green-400',
        'text'    => 'text-green-800 dark:text-green-300',
        'close'   => 'text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-200',
        'svg'     => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z',
    ],
    'error' => [
        'wrapper' => 'bg-red-50 border-red-200 dark:bg-red-950 dark:border-red-800',
        'icon'    => 'text-red-500 dark:text-red-400',
        'text'    => 'text-red-800 dark:text-red-300',
        'close'   => 'text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-200',
        'svg'     => 'M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z',
    ],
    'warning' => [
        'wrapper' => 'bg-yellow-50 border-yellow-200 dark:bg-yellow-950 dark:border-yellow-800',
        'icon'    => 'text-yellow-500 dark:text-yellow-400',
        'text'    => 'text-yellow-800 dark:text-yellow-300',
        'close'   => 'text-yellow-500 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-200',
        'svg'     => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z',
    ],
    'info' => [
        'wrapper' => 'bg-blue-50 border-blue-200 dark:bg-blue-950 dark:border-blue-800',
        'icon'    => 'text-blue-500 dark:text-blue-400',
        'text'    => 'text-blue-800 dark:text-blue-300',
        'close'   => 'text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200',
        'svg'     => 'M11.25 11.25l.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z',
    ],
];

$s = $styles[$type] ?? $styles['info'];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak
    {{ $attributes->merge(['class' => 'rounded-lg border p-4 ' . $s['wrapper']]) }}
    role="alert"
>
    <div class="flex items-start gap-3">
        <svg class="mt-0.5 h-5 w-5 shrink-0 {{ $s['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['svg'] }}" />
        </svg>

        <p class="flex-1 text-sm {{ $s['text'] }}">{{ $slot }}</p>

        @if ($dismissible)
            <button
                type="button"
                @click="show = false"
                class="shrink-0 rounded {{ $s['close'] }} transition-colors"
                aria-label="Close"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        @endif
    </div>
</div>
