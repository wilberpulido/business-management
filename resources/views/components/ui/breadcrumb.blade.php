@props([
    'items' => [],
])

<nav class="flex items-center gap-x-1.5 text-sm mb-6">
    @foreach($items as $index => $item)
        @if($index > 0)
            <span class="text-gray-400 dark:text-slate-600">›</span>
        @endif

        @if(! $loop->last)
            <a
                href="{{ isset($item['route']) ? route($item['route']) : $item['url'] }}"
                wire:navigate
                class="text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200 transition-colors"
            >
                {{ $item['label'] }}
            </a>
        @else
            <span class="text-gray-900 dark:text-white font-medium">
                {{ $item['label'] }}
            </span>
        @endif
    @endforeach
</nav>
