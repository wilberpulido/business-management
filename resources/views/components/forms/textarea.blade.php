@props(['rows' => 3])

<textarea
    rows="{{ $rows }}"
    class="block w-full rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition duration-150 ease-in-out sm:text-sm shadow-sm"
    {{ $attributes }}
>{{ $slot }}</textarea>
