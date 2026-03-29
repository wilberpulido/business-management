@props([
    'src'  => null,
    'name' => '',
    'size' => 'md',
])

@php
$sizes = [
    'sm' => 'h-8 w-8 text-xs',
    'md' => 'h-10 w-10 text-sm',
    'lg' => 'h-14 w-14 text-base',
];

$sizeClass = $sizes[$size] ?? $sizes['md'];

$initials = collect(explode(' ', trim($name)))
    ->filter()
    ->take(2)
    ->map(fn ($w) => strtoupper($w[0]))
    ->implode('');
@endphp

@if ($src)
    <img
        src="{{ $src }}"
        alt="{{ $name }}"
        {{ $attributes->merge(['class' => 'rounded-full object-cover ' . $sizeClass]) }}
    />
@else
    <span {{ $attributes->merge(['class' => 'inline-flex items-center justify-center rounded-full bg-indigo-600 dark:bg-indigo-500 font-semibold text-white ' . $sizeClass]) }}>
        {{ $initials ?: '?' }}
    </span>
@endif
