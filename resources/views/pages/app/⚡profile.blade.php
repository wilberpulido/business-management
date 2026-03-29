<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<x-layouts.app :title="__('ui.profile.title')">

    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
            {{ __('ui.profile.title') }}
        </h1>
    </div>

    <div class="space-y-6">

        {{-- Update Profile Information --}}
        <x-ui.card>
            <x-slot:header>
                <div>
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">
                        {{ __('ui.profile.update_info') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">
                        {{ __('ui.profile.update_info_description') }}
                    </p>
                </div>
            </x-slot:header>

            @if (session('status') === 'profile-information-updated')
                <x-ui.alert type="success" class="mb-4">{{ __('ui.profile.saved') }}</x-ui.alert>
            @endif

            <form method="POST" action="{{ route('user-profile-information.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('ui.auth.name') }}
                    </label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', auth()->user()->name) }}"
                        autocomplete="name"
                        class="block w-full rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition duration-150 ease-in-out sm:text-sm shadow-sm"
                    />
                    @error('name', 'updateProfileInformation')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('ui.auth.email') }}
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', auth()->user()->email) }}"
                        autocomplete="email"
                        class="block w-full rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition duration-150 ease-in-out sm:text-sm shadow-sm"
                    />
                    @error('email', 'updateProfileInformation')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <x-ui.button>{{ __('ui.buttons.save') }}</x-ui.button>
                </div>
            </form>
        </x-ui.card>

        {{-- Change Password --}}
        <x-ui.card>
            <x-slot:header>
                <div>
                    <h2 class="text-base font-semibold text-slate-900 dark:text-white">
                        {{ __('ui.profile.change_password') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">
                        {{ __('ui.profile.change_password_description') }}
                    </p>
                </div>
            </x-slot:header>

            @if (session('status') === 'password-updated')
                <x-ui.alert type="success" class="mb-4">{{ __('ui.profile.saved') }}</x-ui.alert>
            @endif

            <form method="POST" action="{{ route('user-password.update') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('ui.profile.current_password') }}
                    </label>
                    <input
                        id="current_password"
                        name="current_password"
                        type="password"
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="block w-full rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition duration-150 ease-in-out sm:text-sm shadow-sm"
                    />
                    @error('current_password', 'updatePassword')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('ui.auth.new_password') }}
                    </label>
                    <input
                        id="new_password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="block w-full rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition duration-150 ease-in-out sm:text-sm shadow-sm"
                    />
                    @error('password', 'updatePassword')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('ui.auth.confirm_password') }}
                    </label>
                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        placeholder="••••••••"
                        class="block w-full rounded-lg border border-gray-300 dark:border-slate-700 bg-white dark:bg-slate-800 px-4 py-2.5 text-gray-900 dark:text-white placeholder:text-gray-400 dark:placeholder:text-slate-500 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition duration-150 ease-in-out sm:text-sm shadow-sm"
                    />
                    @error('password_confirmation', 'updatePassword')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <x-ui.button>{{ __('ui.profile.change_password') }}</x-ui.button>
                </div>
            </form>
        </x-ui.card>

    </div>

</x-layouts.app>
