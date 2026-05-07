{{-- Tailwind safelist: top-full mt-1 bottom-full mb-1 origin-top origin-bottom rotate-180 font-semibold --}}
@props([
    'name',
    'label'       => null,
    'options'     => [],
    'placeholder' => '—',
    'value'       => null,
    'searchable'  => false,
    'disabled'    => false,
])

@php
    $normalized = collect($options)
        ->map(fn($label, $value) => ['value' => $value, 'label' => $label])
        ->values()
        ->all();
    $optionsJson = json_encode($normalized, JSON_HEX_QUOT | JSON_HEX_TAG);
    $jsValue     = $value !== null ? (int) $value : 'null';
    $hasError    = $errors->has($name);
    $labelClass  = 'block text-sm font-medium mb-1.5 ' . ($hasError ? 'text-red-600 dark:text-red-400' : 'text-gray-700 dark:text-slate-300');
@endphp

<div
    x-data="combobox({ value: {{ $jsValue }}, searchable: {{ $searchable ? 'true' : 'false' }}, placeholder: '{{ addslashes($placeholder) }}' })"
    class="relative"
    @keydown.escape="close()"
    @keydown.arrow-down.prevent="open ? navigate('down') : toggle()"
    @keydown.arrow-up.prevent="open ? navigate('up') : toggle()"
    @keydown.enter.prevent="open ? selectHighlighted() : toggle()"
>
    {{-- Data element morfeable por Livewire --}}
    <span hidden x-ref="optionsData" data-options="{{ $optionsJson }}" aria-hidden="true"></span>

    {{-- Input oculto para wire:model --}}
    <input type="hidden" x-ref="input" :value="value" {{ $attributes->whereStartsWith('wire:model') }} />

    @if($label)
        <label for="{{ $name }}" class="{{ $labelClass }}">{{ $label }}</label>
    @endif

    {{-- Trigger --}}
    <button
        x-ref="trigger"
        type="button"
        @click="toggle()"
        :aria-expanded="open"
        aria-haspopup="listbox"
        {{ $disabled ? 'disabled' : '' }}
        class="relative w-full cursor-pointer rounded-lg border border-gray-300 bg-white px-3 py-2 pr-10
               text-left text-sm text-gray-900 shadow-sm transition duration-150 ease-in-out
               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none
               disabled:cursor-not-allowed disabled:opacity-50
               dark:bg-slate-900 dark:border-slate-700 dark:text-white
               dark:focus:border-indigo-400 dark:focus:ring-indigo-400/20"
        :class="open ? 'border-indigo-500 ring-2 ring-indigo-500/20 dark:border-indigo-400' : ''"
    >
        <span x-text="selectedLabel || placeholder"
              :class="selectedLabel ? 'text-gray-900 dark:text-white' : 'text-gray-400 dark:text-slate-500'">
        </span>
        <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
            <svg class="h-4 w-4 text-gray-400 dark:text-slate-500 transition-transform duration-150"
                 :class="open ? 'rotate-180' : ''"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </span>
    </button>

    {{-- Dropdown panel --}}
    <div
        x-show="open"
        x-cloak
        @click.outside="close()"
        x-ref="listbox"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        role="listbox"
        class="absolute z-50 w-full rounded-lg border border-gray-100 bg-white shadow-lg
               dark:border-slate-800 dark:bg-slate-900"
        :class="{
            'top-full mt-1 origin-top':       position === 'below',
            'bottom-full mb-1 origin-bottom': position === 'above'
        }"
    >
        @if($searchable)
            <div class="border-b border-gray-100 p-2 dark:border-slate-800">
                <input
                    x-ref="searchInput"
                    x-model="search"
                    type="text"
                    placeholder="{{ __('ui.search') }}"
                    autocomplete="off"
                    class="block w-full rounded-md border border-gray-200 bg-white px-3 py-1.5 text-sm
                           placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2
                           focus:ring-indigo-500/20 focus:outline-none
                           dark:bg-slate-800 dark:border-slate-700 dark:text-white
                           dark:placeholder:text-slate-500 dark:focus:border-indigo-400"
                />
            </div>
        @endif

        <ul :style="{ maxHeight: listHeight + 'px' }" class="overflow-y-auto py-1">
            <template x-if="filtered.length === 0">
                <li class="px-3 py-2 text-center text-sm text-gray-400 dark:text-slate-500">
                    {{ __('ui.no_results') }}
                </li>
            </template>
            <template x-for="(option, index) in filtered" :key="option.value">
                <li
                    role="option"
                    :aria-selected="isSelected(option)"
                    :data-highlighted="index === highlighted"
                    @click="select(option)"
                    @mouseenter="highlighted = index"
                    class="relative cursor-pointer select-none px-3 py-2 text-sm transition-colors duration-75"
                    :class="{
                        'bg-indigo-600 text-white dark:bg-indigo-500': index === highlighted,
                        'text-gray-900 dark:text-white': index !== highlighted
                    }"
                >
                    <span x-text="option.label" :class="isSelected(option) ? 'font-semibold' : ''"></span>
                    <span x-show="isSelected(option)" class="absolute inset-y-0 right-3 flex items-center">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </span>
                </li>
            </template>
        </ul>
    </div>

    <x-forms.error :field="$name" :reserved="false" />
</div>
