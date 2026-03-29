@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold transition-all duration-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 disabled:opacity-50 disabled:pointer-events-none';

    $variants = [
        'primary' => 'bg-indigo-600 text-white hover:bg-indigo-500 shadow-sm dark:bg-indigo-500 dark:hover:bg-indigo-400',
        'secondary' => 'bg-white text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 dark:bg-slate-800 dark:text-white dark:ring-slate-700 dark:hover:bg-slate-700',
        'danger' => 'bg-red-600 text-white hover:bg-red-500 dark:bg-red-500 dark:hover:bg-red-400',
        'ghost'     => 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-slate-100',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs rounded-md',
        'md' => 'px-4 py-2 text-sm rounded-lg',
        'lg' => 'px-6 py-3 text-base rounded-xl',
    ];

    $classes = "{$baseClasses} {$variants[$variant]} {$sizes[$size]}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
