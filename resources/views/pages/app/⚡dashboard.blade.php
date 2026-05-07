<?php

use App\Models\Enterprise;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

new class extends Component
{
    public function getEnterprise(): ?Enterprise
    {
        return auth()->user()->enterprise;
    }

    public function getBranchCount(): int
    {
        return auth()->user()->enterprise?->branches()->count() ?? 0;
    }

    public function getActivities()
    {
        return Activity::causedBy(auth()->user())
            ->latest()
            ->take(10)
            ->get();
    }
};
?>

<x-layouts.app :title="__('ui.dashboard.title')">

    {{-- Header --}}
    <div class="mb-8">
        <div class="flex justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
                    {{ __('ui.dashboard.welcome', ['name' => auth()->user()->name]) }}
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">
                    {{ __('ui.dashboard.subtitle') }}
                </p>
            </div>
            <div class="mt-4">
                <x-ui.button variant="primary" :href="route('company.profile')" wire:navigate>
                    {{ __('ui.dashboard.setup.company_profile_link') }}
                </x-ui.button>
            </div>
        </div>
    </div>

    {{-- Setup CTAs --}}
    @if (! $this->getEnterprise())
        <div class="mb-8 rounded-xl border-2 border-dashed border-indigo-200 dark:border-indigo-800 bg-indigo-50/40 dark:bg-indigo-950/30 p-8 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 dark:bg-indigo-900">
                <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                </svg>
            </div>
            <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                {{ __('ui.dashboard.setup.company_title') }}
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-slate-400 max-w-sm mx-auto">
                {{ __('ui.dashboard.setup.company_description') }}
            </p>
            <div class="mt-4">
                <x-ui.button :href="route('company.profile')" wire:navigate>
                    {{ __('ui.dashboard.setup.company_button') }}
                </x-ui.button>
            </div>
        </div>
    @elseif ($this->getBranchCount() === 0)
        <div class="mb-8 rounded-xl border-2 border-dashed border-amber-200 dark:border-amber-800 bg-amber-50/40 dark:bg-amber-950/30 p-8 text-center">
            <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900">
                <svg class="h-6 w-6 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
            </div>
            <h3 class="text-base font-semibold text-slate-900 dark:text-white">
                {{ __('ui.dashboard.setup.branch_title') }}
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-slate-400 max-w-sm mx-auto">
                {{ __('ui.dashboard.setup.branch_description') }}
            </p>
            <p class="mt-3 text-xs text-gray-400 dark:text-slate-500">
                {{ __('ui.dashboard.setup.coming_soon') }}
            </p>
        </div>
    @endif

    {{-- Stats --}}
    {{--
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        @foreach ([
            ['label' => __('ui.dashboard.stats.users'),   'value' => '—', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0'],
            ['label' => __('ui.dashboard.stats.revenue'), 'value' => '—', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => __('ui.dashboard.stats.orders'),  'value' => '—', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
            ['label' => __('ui.dashboard.stats.growth'),  'value' => '—', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6'],
        ] as $stat)
            <div class="bg-white dark:bg-slate-950 rounded-xl border border-gray-200 dark:border-slate-800 p-5 flex items-center gap-4">
                <div class="shrink-0 p-2 bg-indigo-50 dark:bg-indigo-950 rounded-lg">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-500 dark:text-slate-400">{{ $stat['label'] }}</p>
                    <p class="text-xl font-semibold text-slate-900 dark:text-white">{{ $stat['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
    --}}
    {{-- Recent Activity --}}
    {{--
    <x-ui.card>
        <x-slot:header>
            <h2 class="text-base font-semibold text-slate-900 dark:text-white">
                {{ __('ui.dashboard.recent_activity') }}
            </h2>
        </x-slot:header>

        @php $activities = $this->getActivities() @endphp

        @if ($activities->isEmpty())
            <p class="text-sm text-gray-400 dark:text-slate-500">
                {{ __('ui.dashboard.no_activity') }}
            </p>
        @else
            <ul class="divide-y divide-gray-100 dark:divide-slate-800 -my-2">
                @foreach ($activities as $activity)
                    <li class="flex items-center justify-between py-3 gap-4">
                        <div class="flex items-center gap-3">
                            <x-ui.badge :color="match($activity->description) {
                                'logged_in'  => 'green',
                                'logged_out' => 'gray',
                                'registered' => 'indigo',
                                'updated'    => 'blue',
                                'created'    => 'green',
                                'deleted'    => 'red',
                                default      => 'gray',
                            }">
                                {{ $activity->description }}
                            </x-ui.badge>
                            @if ($activity->subject_type && $activity->subject_type !== get_class(auth()->user()))
                                <span class="text-sm text-gray-500 dark:text-slate-400">
                                    {{ class_basename($activity->subject_type) }}
                                </span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-400 dark:text-slate-500 shrink-0">
                            {{ $activity->created_at->diffForHumans() }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-ui.card>
    --}}
</x-layouts.app>
