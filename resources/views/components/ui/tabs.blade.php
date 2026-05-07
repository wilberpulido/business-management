@props([
    'items'    => [],
    'urlParam' => null,
    'default'  => null,
])

@php
    $defaultTab = $default ?? ($items[0]['id'] ?? '');
@endphp

<div
    x-data="{
        activeTab: '{{ $defaultTab }}',
        init() {
            @if($urlParam)
            const param = new URLSearchParams(location.search).get('{{ $urlParam }}');
            if (param) this.activeTab = param;
            this.$watch('activeTab', tab => {
                const url = new URL(location.href);
                url.searchParams.set('{{ $urlParam }}', tab);
                history.pushState({}, '', url);
            });
            @endif
        }
    }"
>
    <div class="flex border-b border-gray-200 dark:border-slate-800 mb-6">
        @foreach($items as $item)
            <button
                type="button"
                @click="activeTab = '{{ $item['id'] }}'"
                :class="activeTab === '{{ $item['id'] }}'
                    ? 'border-b-2 border-indigo-600 text-indigo-600 dark:border-indigo-400 dark:text-indigo-400'
                    : 'border-b-2 border-transparent text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200'"
                class="-mb-px px-4 py-2.5 text-sm font-medium transition-colors"
            >
                {{ $item['label'] }}
            </button>
        @endforeach
    </div>

    {{ $slot }}
</div>
