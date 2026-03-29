<?php

use Livewire\Component;

use Spatie\Activitylog\Models\Activity;

new class extends Component
{
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
        <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
            {{ __('ui.dashboard.welcome', ['name' => auth()->user()->name]) }}
        </h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">
            {{ __('ui.dashboard.subtitle') }}
        </p>
    </div>

    {{-- Stats --}}
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

    {{-- Recent Activity --}}
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

</x-layouts.app>
