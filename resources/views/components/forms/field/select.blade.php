@props([
    'name',
    'label'       => null,
    'options'     => [],
    'placeholder' => '—',
    'value'       => null,
])

<div>
    @if($label)
        <x-forms.label for="{{ $name }}">{{ $label }}</x-forms.label>
    @endif

    <select
        id="{{ $name }}"
        class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-900
        focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none
        dark:bg-slate-900 dark:border-slate-700 dark:text-white dark:focus:border-indigo-400 dark:focus:ring-indigo-400/20
        disabled:opacity-50 disabled:cursor-not-allowed
        transition duration-150 ease-in-out shadow-sm"
        {{ $attributes }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach($options as $optValue => $optLabel)
            <option value="{{ $optValue }}" @selected($value !== null && $value == $optValue)>
                {{ $optLabel }}
            </option>
        @endforeach
    </select>

    <x-forms.error :field="$name" />
</div>
