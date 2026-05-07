@props(['id'])

<div x-show="activeTab === '{{ $id }}'">
    {{ $slot }}
</div>
