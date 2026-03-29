<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    function setupTheme() {
        const theme = localStorage.getItem('theme') || 'light';
        document.documentElement.classList.toggle('dark', theme === 'dark');
    }
    setupTheme();
    document.addEventListener('livewire:navigated', setupTheme);
    </script>

    @livewireStyles
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 text-slate-900 dark:bg-slate-900 dark:text-white transition-colors duration-500">
    <div class="min-h-screen flex flex-col">
        <x-layouts.navigation />

        <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 pt-24">
            @if (session('success'))
                <x-ui.alert type="success" class="mb-6">{{ session('success') }}</x-ui.alert>
            @endif
            @if (session('error'))
                <x-ui.alert type="error" class="mb-6">{{ session('error') }}</x-ui.alert>
            @endif
            @if (session('status'))
                <x-ui.alert type="info" class="mb-6">{{ session('status') }}</x-ui.alert>
            @endif
            {{ $slot }}
        </main>
    </div>
    @livewireScripts
</body>
</html>
