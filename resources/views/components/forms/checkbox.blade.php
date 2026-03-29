@props([
    'name'  => '',
    'label' => null,
    'value' => '1',
])

<label class="inline-flex items-center gap-3 cursor-pointer">
    <input
        type="checkbox"
        name="{{ $name }}"
        value="{{ $value }}"
        class="w-4 h-4 rounded border-gray-300 dark:border-slate-600 text-indigo-600 focus:ring-indigo-500 dark:bg-slate-800 dark:checked:bg-indigo-500"
        {{ $attributes }}
    />
    @if ($label)
        <span class="text-sm text-gray-700 dark:text-slate-300">{{ $label }}</span>
    @elseif ($slot->isNotEmpty())
        <span class="text-sm text-gray-700 dark:text-slate-300">{{ $slot }}</span>
    @endif
</label>
@if ($name)
    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
@endif
