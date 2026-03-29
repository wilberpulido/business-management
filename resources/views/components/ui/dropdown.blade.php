@props([
    'align' => 'right',
    'width' => '48',
])

@php
$alignClass = $align === 'left' ? 'left-0' : 'right-0';
@endphp

<div x-data="{ open: false }" class="relative" {{ $attributes }}>
    {{-- Trigger --}}
    <div @click="open = !open" @click.outside="open = false">
        {{ $trigger }}
    </div>

    {{-- Panel --}}
    <div
        x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute {{ $alignClass }} mt-2 w-{{ $width }} bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-lg shadow-lg py-1 z-50"
        @click="open = false"
    >
        {{ $slot }}
    </div>
</div>
