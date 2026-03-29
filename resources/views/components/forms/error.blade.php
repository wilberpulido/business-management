@props(['field'=>''])
<div class="min-h-[24px]">
    <span class="mt-2 text-sm text-red-600 dark:text-red-500" role="alert">
        {{ $errors->first($field) }}
    </span>
</div>

