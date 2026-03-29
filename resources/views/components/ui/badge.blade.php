@props([
    'color' => 'gray',
])

@php
$colors = [
    'gray'   => 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
    'green'  => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
    'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
    'red'    => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
    'blue'   => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
    'indigo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
];

$colorClass = $colors[$color] ?? $colors['gray'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ' . $colorClass]) }}>
    {{ $slot }}
</span>
