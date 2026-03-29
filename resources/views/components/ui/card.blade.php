@props([
    'padding' => 'md',
])

@php
$paddings = [
    'none' => '',
    'sm'   => 'p-4',
    'md'   => 'p-6',
    'lg'   => 'p-8',
];

$bodyPadding = $paddings[$padding] ?? $paddings['md'];
@endphp

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-slate-950 rounded-xl border border-gray-200 dark:border-slate-800 shadow-sm']) }}>
    @isset($header)
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-800">
            {{ $header }}
        </div>
    @endisset

    <div class="{{ $bodyPadding }}">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-800">
            {{ $footer }}
        </div>
    @endisset
</div>
