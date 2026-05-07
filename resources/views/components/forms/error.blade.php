@props(['field' => '', 'reserved' => true])
<div @class(['min-h-[24px]' => $reserved])>
    <span class="mt-2 text-sm text-red-600 dark:text-red-500" role="alert">
        {{ $errors->first($field) }}
    </span>
</div>

