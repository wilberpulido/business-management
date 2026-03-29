@props(['for'])
@php
    $hasError = $errors->has($for ?? '');
    $classes = 'block text-sm font-medium mb-1 ' . ($hasError ? 'text-red-600 dark:text-red-400' : 'text-gray-700');
@endphp

<label {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</label>
